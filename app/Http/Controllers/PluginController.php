<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePluginRequest;
use App\Http\Requests\UpdatePluginRequest;
use App\Models\Plugin;
use App\Repositories\PluginRepository;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Response;

class PluginController extends AppBaseController
{
    /** @var  PluginRepository */
    private $pluginRepository;

    public function __construct(PluginRepository $pluginRepo)
    {
        $this->middleware('auth');
//        $this->authorizeResource(Plugin::class, 'plugin');
        $this->pluginRepository = $pluginRepo;
    }

    /**
     * Display a listing of the Plugin.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $plugins = $this->pluginRepository->all(
            ['user_id' => auth()->id()]
        );

        $soft_deleted = Plugin::onlyTrashed()->where('user_id', auth()->id())->get();

        return view('studio.plugins.index', [
            'plugins' => $plugins,
            'soft_deleted' => $soft_deleted,
        ]);
    }

    /**
     * Display a listing of the Plugin.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function showcase(Request $request)
    {
        $plugins = $this->pluginRepository->all();

        return view('studio.plugins.showcase.index')
            ->with('plugins', $plugins);
    }

    /**
     * Show the form for creating a new Plugin.
     *
     * @return Response
     */
    public function create()
    {
        return view('studio.plugins.create');
    }

    /**
     * Store a newly created Plugin in storage.
     *
     * @param CreatePluginRequest $request
     *
     * @return Response
     */
    public function store(CreatePluginRequest $request)
    {
        $input = $request->all();

        $plugin = $this->pluginRepository->create($input);

        Flash::success('Plugin saved successfully.');

        return redirect(route('studio.plugins.index'));
    }

    /**
     * Display the specified Plugin.
     *
     * @param Plugin $plugin
     * @return Response
     */
    public function show(Plugin $plugin)
    {
//        $plugin = $this->pluginRepository->find($id);

        if (empty($plugin)) {
            Flash::error('Plugin not found');

            return redirect(route('studio.plugins.index'));
        }

        if ($plugin->user_id != auth()->id()) {
            return redirect(route('studio.plugins.index'));
        }

        return view('studio.plugins.show')->with('plugin', $plugin);
    }

    /**
     * Show the form for editing the specified Plugin.
     *
     * @param Plugin $plugin
     * @return Response
     */
    public function edit(Plugin $plugin)
    {
        if (empty($plugin)) {
            Flash::error('Plugin not found');

            return redirect(route('studio.plugins.index'));
        }

        if ($plugin->user_id != auth()->id()) {
            return redirect(route('studio.plugins.index'));
        }

        return view('studio.plugins.edit')->with('plugin', $plugin);
    }

    /**
     * Update the specified Plugin in storage.
     *
     * @param Plugin $plugin
     * @param UpdatePluginRequest $request
     *
     * @return Response
     */
    public function update(Plugin $plugin, UpdatePluginRequest $request)
    {
        if (empty($plugin)) {
            Flash::error('Plugin not found');

            return redirect(route('studio.plugins.index'));
        }

        if ($plugin->user_id != auth()->id()) {
            return redirect(route('studio.plugins.index'));
        }

        $plugin = $this->pluginRepository->update($request->all(), $plugin->id);

        $extra_scripts = <<<EOD
                <script>
                    $(function() {
                        Swal.fire({
                            icon: 'success',
                            iconHtml: '<i class="fas fa-cogs"><i/>',
                            title: 'Processing plugin..',
                            html: 'Your plugin was uploaded. We are currently processing it to extract all of its valuable information. This process takes usually takes about <strong>a minute</strong>. You\'ll be notified when the build process is complete.',
                            confirmButtonText: 'Awesome! <i class="fas fa-glass-cheers"></i>',
                        });
                    });
                </script>
EOD;
        Session::flash('extra_scripts', $extra_scripts);

        return redirect(route('studio.plugins.index'));
    }

    /**
     * Remove the specified Plugin from storage.
     *
     * @param $plugin_id
     * @return Response
     * @throws \Exception
     */
    public function forceDelete(int $plugin_id)
    {
        $plugin = Plugin::withTrashed()->findOrFail($plugin_id);

        if ($plugin->user_id != auth()->id()) {
            return redirect(route('studio.plugins.index'));
        }

        try {
            $plugin->forceDelete();
            dd('hi');
        }catch(\Illuminate\Database\QueryException $ex){
            Flash::error("$plugin->title is currently used by some games and can't be deleted at this moment.");
            return redirect(route('studio.plugins.index'));
        }

        Flash::success('Plugin deleted successfully.');

        return redirect(route('studio.plugins.index'));
    }

    /**
     * Remove the specified Plugin from storage.
     *
     * @param $plugin_id
     * @return Response
     * @throws \Exception
     */
    public function restore(int $plugin_id)
    {
        $plugin = Plugin::withTrashed()->findOrFail($plugin_id);
        if ($plugin->user_id != auth()->id()) {
            return redirect(route('studio.plugins.index'));
        }

        $plugin->restore();

        Flash::success('Plugin restored successfully.');

        return redirect(route('studio.plugins.index'));
    }

    /**
     * Remove the specified Plugin from storage.
     *
     * @param Plugin $plugin
     * @return Response
     * @throws \Exception
     */
    public function destroy(Plugin $plugin)
    {
        if (empty($plugin)) {
            Flash::error('Plugin not found');

            return redirect(route('studio.plugins.index'));
        }

        if ($plugin->user_id != auth()->id()) {
            return redirect(route('studio.plugins.index'));
        }

        if(empty($plugin->plugin_source)) {
            return $this->forceDelete($plugin->id);
        }

        $this->pluginRepository->delete($plugin->id);

        Flash::success('Plugin deleted successfully.');

        return redirect(route('studio.plugins.index'));
    }



    /**
     * Download the specified Plugin from storage.
     *
     * @param Plugin $plugin
     * @return Response
     * @throws \Exception
     */
    public function download(Plugin $plugin)
    {
        if(empty($plugin)){
            Flash::error('Plugin not found');

            return redirect(route('studio.plugins.index'));
        }
        if(!$plugin->plugin_source) {
            Flash::error('Plugin has no source to download');
            return redirect(route('studio.plugins.index'));
        }

        return $plugin->downloadSource();
    }

    /**
     * Delete the source of a specified Plugin from storage.
     *
     * @param Plugin $plugin
     * @return Response
     * @throws \Exception
     */
    public function deleteSource(Plugin $plugin)
    {
        if(empty($plugin)){
            Flash::error('Plugin not found');
            return redirect(route('studio.plugins.index'));
        }

        if(!$plugin->plugin_source) return;
        if(Storage::cloud()->exists($plugin->plugin_source)) {
            Storage::cloud()->delete($plugin->plugin_source);
        }
        $plugin->plugin_source = null;
        $plugin->save();
    }
}
