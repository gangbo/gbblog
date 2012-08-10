package com.gangbo.webview;

import java.io.File;
import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.os.Environment;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.Button;

public class MainActivity extends Activity implements OnClickListener {
	protected WebView webView;
	protected Button startSecondActivityBtn;

	@Override
	public void onCreate(Bundle savedInstanceState) {
		Log.d("====", "mainactivity oncreate");
		super.onCreate(savedInstanceState);
		setContentView(R.layout.main);

		webView = ((WebView) findViewById(R.id.webView));
		startSecondActivityBtn = ((Button) findViewById(R.id.startSecondActivityBtn));

		// Set the listener
		startSecondActivityBtn.setOnClickListener(this);

		// Initialize the WebView
		webView.getSettings().setSupportZoom(true);
		webView.getSettings().setBuiltInZoomControls(true);
		webView.setScrollBarStyle(WebView.SCROLLBARS_OUTSIDE_OVERLAY);
		webView.setScrollbarFadingEnabled(true);
		webView.getSettings().setLoadsImagesAutomatically(true);
		webView.getSettings().setAppCacheMaxSize(1024 * 1024 * 8);
		webView.getSettings().setCacheMode(WebSettings.LOAD_CACHE_ELSE_NETWORK);

		// Load the URLs inside the WebView, not in the external web browser
		webView.setWebViewClient(new WebViewClient());

		webView.loadUrl("http://10.132.64.207:9800/kcollection/list");
	}

	@Override
	protected void onDestroy() {
		// Clear the cache (this clears the WebViews cache for the entire
		// application)
		webView.clearCache(true);
		super.onDestroy();
	}

	@Override
	public File getCacheDir() {
		// NOTE: this method is used in Android 2.1
		// return getApplicationContext().getCacheDir();
		Log.d("=======","getcacheDir");
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

	@Override
	public void onClick(View v) {
		if (v == startSecondActivityBtn) {
			Intent intent = new Intent(this, SecondActivity.class);
			startActivity(intent);
		}
	}
}