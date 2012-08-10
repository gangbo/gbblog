package com.gangbo.webview;

import java.io.File;
import android.app.Application;
import android.os.Environment;
import android.util.Log;

public class ApplicationExt extends Application {
	// NOTE: the content of this path will be deleted
	// when the application is uninstalled (Android 2.2 and higher)
	protected File extStorageAppBasePath;
	protected File extStorageAppCachePath;

	@Override
	public void onCreate() {
		super.onCreate();
		Log.d("==", "application Ext oncreate");
/*
		// Check if the external storage is writeable
		if (Environment.MEDIA_MOUNTED.equals(Environment
				.getExternalStorageState())) {
			// Retrieve the base path for the application in the external
			// storage
			File externalStorageDir = Environment.getExternalStorageDirectory();

			if (externalStorageDir != null) {
				// {SD_PATH}/Android/data/com.devahead.androidwebviewcacheonsd
				extStorageAppBasePath = new File(
						externalStorageDir.getAbsolutePath() + File.separator
								+ "mynote" + File.separator + getPackageName()
								+ File.separator + "webviewcache");
			}

			if (extStorageAppBasePath != null) {
				// {SD_PATH}/Android/data/com.devahead.androidwebviewcacheonsd/cache
				extStorageAppCachePath = new File(
						extStorageAppBasePath.getAbsolutePath()
								+ File.separator + "cache");

				boolean isCachePathAvailable = true;

				if (!extStorageAppCachePath.exists()) {
					// Create the cache path on the external storage
					isCachePathAvailable = extStorageAppCachePath.mkdirs();
				}

				if (!isCachePathAvailable) {
					// Unable to create the cache path
					extStorageAppCachePath = null;
				}
			}
		}
		*/
	}

	@Override
	public File getCacheDir() {
		// NOTE: this method is used in Android 2.2 and higher

		boolean isCachePathAvailable = true;
		File extStorageAppCachePath = new File(Environment
				.getExternalStorageDirectory().getAbsolutePath()
				+ File.separator + "aagangbo" + File.separator + "cache");
		Log.d("====", "="+extStorageAppCachePath.getAbsolutePath());	
		if (!extStorageAppCachePath.exists()) {
			// Create the cache path on the external storage
			isCachePathAvailable = extStorageAppCachePath.mkdirs();
		}

		if (!isCachePathAvailable) {
			// Unable to create the cache path
			extStorageAppCachePath = null;
		}
		return extStorageAppCachePath;
	}
}