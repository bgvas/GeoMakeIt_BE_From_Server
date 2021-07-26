[Android Studio]: https://developer.android.com/studio
[Kotlin]: https://kotlinlang.org/
[SIGN-IN/SIGN-UP]: http:://geomakeit.com/login
[GeoMakeIt!]: http://geomakeit.com/
[GeoMakeIt! API]: http://geomakeit.com/
[upgrade to a developer account]: /upgrade-to-a-developer-account.md
[download the starter project]: https://github.com/GeoMakeIt/Demo-Project

* [Sign-in/Sign-up to GeoMakeIt!](#sign-insign-up-to-geomakeit)
* [Registering your plugin](#registering-your-plugin)
  * [Choosing an identifier](#choosing-an-identifier)
* [Creating your first plugin](#creating-your-first-plugin)
  * [Downloading GeoMakeIt! Starter Project](#downloading-geomakeit-starter-project)
  * [Creating your plugin](#creating-your-plugin)
    * [Hello World](#hello-world)
    * [Running your application](#running-your-application)

## Sign-in/Sign-up to GeoMakeIt!
1. Navigate to [GeoMakeIt!]
2. Go to **[SIGN-IN/SIGN-UP]**
    1. _If this is your **_first time signing up_**_, make sure to **register for a developer account**, and follow the instructions there
    2. _If you are already signed up for a creator account_, you can **[upgrade to a developer account]**

## Registering your plugin
Even though registering your plugin is **optional at early stages**, we do recommend this in order to secure your unique
identifier for your plugin.

### Choosing an identifier
Each plugin is required to have a unique identifier to be able to communicate with other plugins.
On top of that, the identifier serves as the gate for your user interaction such as [commands] & [placeholders]. As such,
make sure to choose the appropriate identifier for your plugin.

Keep in mind that people remember easier the following:
 * Descriptive words
 * Short words
 * Common words
 * Words that don't contain numbers or symbols

_Kinda like creating the worlds most insecure password_.

For example if you were creating a plugin that can create, manage and display a player's score, you could name it as follows:

`score`, `score_api`, `epic_score`, `player_score` e.t.c

Let's have a look on the steps required to register your plugin.
1. Navigate to [GeoMakeIt!] and make sure you are signed in & **a plugin developer**
2. Select **Plugins**
3. Select **+New**
4. Fill out the form
   * Identifier must follow the rules of a simple variable.
      1. **Must start** with a character
      2. Can contain any alphanumeric or '_' character after it
5. Submit and make sure that you have corrected any possible error

Congratulations! Now you have secured the identifier of your choice.

> **Sportsmanship**: Keep in mind that the selected identifier is yours to keep for a limited time. **You must upload a
release** within one month for you **to keep the name indefinitely**. Good & simple names don't come easy, so if you ever
choose to indefinitely abandon a project make sure to release the identifier back to the public.

## Creating your first plugin
### Downloading GeoMakeIt! Starter Project
Well, to start coding you will be required to at least have downloaded the latest GeoMakeIt! API.
You can either follow the the guide on '[understanding the starter project]' and understand a bit more the inner-workings of
GeoMakeIt!, or simply [download the starter project] directly.

Here, we'll focus on the later and we will consider that you have **downloaded the starter project**.

First we must open the project inside Android Studio. We must do the following:
1. Open Android Studio
2. _Open Project_
3. Navigate to the downloaded [GeoMakeIt! Starter Project](#downloading-geomakeit-starter-project)

The starter project already contains a version of the latest [GeoMakeIt! API] located in _/plugins_ folder.

> If you choose to keep developing with the same starter project, remember to manually update the [GeoMakeIt! API] since it doesn't update automatically!

### Creating your plugin
On Android Studio, while you're in the GeoMakeIt! Starter Project:

1. _File > New > New Project_
2. Select **No Activity** and click next
3. Fill **_name_**, **_package_**, **_save location_** & choose the **_language_** of your choice
4. Make sure your **_minimum SDK is API 16_** & click **Finish**

> Please *make sure to choose a package different that com.geomakeit*.

#### Hello World
Let's try to recreate the classic "Hello World!" example. Now, in our case, we are just going to log a message
to our awesome Logcat and thus prove our plugin can be loaded & is functional.

In _java > com.your_package...._ create a new Kotlin file named **Main.kt**
~~~
// Main.kt
package com.your_package...

import com.geomakeit.api.plugin.Plugin

object Main: Plugin() {
    override val identifier: String
        get() = "my_demo_plugin"

    override fun onEnable() {
        logger.i("$identifier got enabled!")
    }

    override fun onDisable() {
        logger.d("$identifier got disabled :(")
    }
}
~~~

> Take note of the following:
> 1. The name Main.kt is optional, but it is just a convention between other GeoMakeIt! Projects
> 2. Instead of **class Main**, we are using **object Main**!
> 3. Make sure to *extend Plugin()* of **com.geomakeit.api.plugin.Plugin**

We could build the plugin now and be done with it, but we haven't connected it to GeoMakeIt! starter project. As such, there is no way to test
what we've made yet. Let's do that next.

#### Running your application
To run our plugin & be able to test it we need to connect it with the GeoMakeIt! starter project. It's actually pretty simple & straightforward:

1. In the Android Studio: _File > Project Structure > Dependencies > Module: app_
2. _**\+** > Module Dependency_
3. Select your plugin and press ok.

Now your project is included in GeoMakeIt!. Let's also ask GeoMakeIt! to load our plugin on startup.
1. Navigate to _app/assets/**plugins.json**_
2. Fill with the following information inside:
~~~
[
  {
    "package": "com.yourpackage....",
    "main": "Main"
  }
]
~~~

And we are ready to run our project!
1. Run the project by clicking |>
2. Go to **Logcat** and search for _\[GeoMakeIt!\]_. This way you can see all the logs created by GeoMakeIt! & other plugins
3. _If you'd like to see only your outputs_, search \[GeoMakeIt!\]\[<<your identifier>>]

















// TODO: REMOVE THIS & ADD THIS TO SEPERATE













#### Prepping for upload to GeoMakeIt!
We must also create the basic configuration of the plugin to make it visible to GeoMakeIt!.

1. In the Android studio, switch to **Project** view
2. Navigate to your projects main directory. It should be located on: _<<Plugin Name>>/src/main_
3. Create a **new directory** called _**assets/<<plugin_identifier>>**_. _Remember, if you haven't registered in an
identifier from '[Choosing an identifier](#choosing-an-identifier)' you can just select one at random and rename it later. Just remember that the identifier
you choose will be needed later too_
4. Inside the new directory called _**assets/<<plugin_identifier>>**_, create a file named `plugin.json` and fill the following contents
~~~
{
  "package": "com.yourpackage....",
  "main": "Main",
  "title": "Hello World",
  "subtitle": "My first plugin",
  "description": "This is the first GeoMakeIt! plugin i'm making, and it shall be awesome!",
  "version": "1.0.0",
  "author": "Your name",
  "gradle_implementations": []
}
~~~