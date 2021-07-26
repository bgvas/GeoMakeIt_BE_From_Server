package com.geomakeit.project

import android.Manifest
import android.app.Activity
import android.content.Intent
import android.os.Bundle
import android.view.animation.Animation
import android.view.animation.AnimationUtils
import android.widget.ImageView
import com.geomakeit.api.App
import com.geomakeit.api.Game
import com.geomakeit.api.activities.JActivity
import com.geomakeit.api.models.users.UserAuth
import com.google.firebase.firestore.ktx.firestore
import com.google.firebase.ktx.Firebase
import java.util.*
import kotlin.concurrent.schedule


class PreLoaderActivity : JActivity() {
    companion object {
        const val PERMISSION_REQUEST_INITIALIZE = 10001
    }

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.app_activity_preloader)

        App.initialize(this, Firebase.firestore)
        Game.setupGameInformation(
            getString(R.string.app_name),
            getString(R.string.app_description),
            getString(R.string.app_version),
            getString(R.string.app_build)
        )

        val preLoaderImageView: ImageView = findViewById(R.id.geomakeit_logo)
        val preLoaderAnimation: Animation = AnimationUtils.loadAnimation(this, R.anim.app_fade_in)
        preLoaderAnimation.setAnimationListener(object : Animation.AnimationListener {
            override fun onAnimationRepeat(animation: Animation?) {}
            override fun onAnimationStart(animation: Animation?) {}

            override fun onAnimationEnd(animation: Animation?) {
                Timer("Pre-Loader", false).schedule(500) {
                    requestPermissions(App.getContext(),
                        arrayOf(
                            Manifest.permission.INTERNET,
                            Manifest.permission.ACCESS_FINE_LOCATION,
                            Manifest.permission.ACCESS_COARSE_LOCATION
                        ),
                        PERMISSION_REQUEST_INITIALIZE,
                        {
                            // TODO: Web-Managed SignIn
                            val loginScreenVisible = UserAuth.showLoginRegisterScreen(App.getCurrentActivity())
                            if(!loginScreenVisible) {
                                finish()
                                startActivity(
                                    Intent(
                                        App.getContext(),
                                        MainActivity::class.java
                                    )
                                )
                            }
                        }
                    )
                }
            }
        })
        preLoaderImageView.startAnimation(preLoaderAnimation) // Set animation to your ImageView
    }

    override fun onActivityResult(requestCode: Int, resultCode: Int, data: Intent?) {
        super.onActivityResult(requestCode, resultCode, data)
        if (requestCode == UserAuth.RC_SIGN_IN) {
            if (resultCode == Activity.RESULT_OK) {
                finish()
                startActivity(Intent(App.getContext(), MainActivity::class.java))
            }
        }
    }
}