package com.geomakeit.project

import android.os.Bundle
import com.geomakeit.api.App
import com.geomakeit.api.activities.JActivity
import com.geomakeit.api.plugin.PluginManager
import com.google.android.gms.maps.GoogleMap
import com.google.android.gms.maps.OnMapReadyCallback
import com.google.android.gms.maps.SupportMapFragment
import java.lang.Exception

class MainActivity : JActivity(), OnMapReadyCallback {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        val resID: Int =
            resources.getIdentifier("app_activity_maps", "layout", packageName)

        setContentView(resID)

        val mapFragment = supportFragmentManager
            .findFragmentById(R.id.map) as SupportMapFragment
        mapFragment.getMapAsync(this)
    }

    override fun onMapReady(p0: GoogleMap?) {
        if(p0 == null) throw Exception("MAP IS UNINITIALIZED?!")
        App.map = p0
        p0.isMyLocationEnabled = true
        p0.uiSettings.isMyLocationButtonEnabled = true
        PluginManager.registerPlugins()
    }
}