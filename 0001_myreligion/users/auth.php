<?php
if (!isset($_SESSION)) {
  session_start();
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>display</title>
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/4.1.5/firebase.js"></script>
<script>
  // Initialize Firebase
  var config = {
    apiKey: "AIzaSyBhpHK-ve2s0ynnr8og8Zx0S69ttEFpDKk",
    authDomain: "project100-fe20e.firebaseapp.com",
    databaseURL: "https://project100-fe20e.firebaseio.com",
    projectId: "project100-fe20e",
    storageBucket: "project100-fe20e.appspot.com",
    messagingSenderId: "674827815611"
  };
  firebase.initializeApp(config);
</script>

<script>
	
	firebase.auth().onAuthStateChanged(function(user) {
	  if (user) {
		var userData = {};
		userData.displayName = user.displayName;
		userData.email = user.email;
		userData.photoURL = user.photoURL;
		userData.profileUID = user.providerData[0].uid;
		userData.refreshToken = user.refreshToken;
		userData.uid = user.uid;
		
	  } else {
		console.log('user is logged out');
	  }
	});
	
	function postToApi(obj) {
		console.log('postToApi obj is ', obj);
		postJson('api.php', obj);
		
	}
	
	//if i have to post json data to server
	function postJson(postUrl, params) {
		var jqxhr = $.ajax({
			url: postUrl,
			type: 'POST',
			data: JSON.stringify(params),
			constenType: 'application/json; charset=utf-8'
		}).done(function(response) {
			console.log('success response = ', response);
			window.location.href = '../home.php';
		}).fail(function(jqxhr, settings, ex) {
			console.log('jqxhr is ', jqxhr);
			console.log('settings is ', settings);
			console.log('ex is ', ex);
		});
	}
	
	//post data in key=value&key1=value1 (Format)
	function post() {
	
	}
	
	// search relate method
	function get() {
	
	}


	function googleLogin() {
		var provider = new firebase.auth.GoogleAuthProvider();
		firebase.auth().signInWithPopup(provider).then(function(result) {
		
			var user = result.user;
			var userData = {};
			userData.displayName = user.displayName;
			userData.email = user.email;
			userData.photoURL = user.photoURL;
			userData.profileUID = user.providerData[0].uid;
			userData.refreshToken = user.refreshToken;
			userData.uid = user.uid;
			userData.provider_id = user.providerData[0].providerId;
			
			postToApi(userData);
		}).catch(function(error) {
		  console.log('error is ', error);
		});
	}
	
	function facebookLogin() {
		var provider = new firebase.auth.FacebookAuthProvider();
		firebase.auth().signInWithPopup(provider).then(function(result) {
		  
			var user = result.user;
			
			var userData = {};
			userData.displayName = user.displayName;
			userData.email = user.email;
			userData.photoURL = user.photoURL;
			userData.profileUID = user.providerData[0].uid;
			userData.refreshToken = user.refreshToken;
			userData.uid = user.uid;
			userData.provider_id = user.providerData[0].providerId;
			
			postToApi(userData);
		}).catch(function(error) {
		  console.log('error is ', error);
		});
	}
	
	//https://apps.twitter.com/
	function twitterLogin() {
		var provider = new firebase.auth.TwitterAuthProvider();
		firebase.auth().signInWithPopup(provider).then(function(result) {
		  var user = result.user;
			
			var userData = {};
			userData.displayName = user.displayName;
			userData.email = user.email;
			userData.photoURL = user.photoURL;
			userData.profileUID = user.providerData[0].uid;
			userData.refreshToken = user.refreshToken;
			userData.uid = user.uid;
			userData.provider_id = user.providerData[0].providerId;
			
			postToApi(userData);
		}).catch(function(error) {
		  console.log('error is ', error);
		});
	}
	
	//https://github.com/settings/developers
	function gitHubLogin() {
		var provider = new firebase.auth.GithubAuthProvider();
		
		firebase.auth().signInWithPopup(provider).then(function(result) {
 			var user = result.user;
			
			var userData = {};
			userData.displayName = user.displayName;
			userData.email = user.email;
			userData.photoURL = user.photoURL;
			userData.profileUID = user.providerData[0].uid;
			userData.refreshToken = user.refreshToken;
			userData.uid = user.uid;
			userData.provider_id = user.providerData[0].providerId;
			
			postToApi(userData);
		}).catch(function(error) {
		 	console.log('error is ', error);
		});
	}
	
	function signOut() {
		firebase.auth().signOut().then(function() {
		  // Sign-out successful.
			console.log('success logout');
		}).catch(function(error) {
		  // An error happened.
			console.log('error logout: ', error);
		});
	}
</script>

</head>

<body>
<p>Firebase Authentication </p>
<p><a href="" onClick="googleLogin(); return false;">Google</a></p>
<p><a href="" onClick="facebookLogin(); return false;">Facebook</a></p>
<p><a href="" onClick="twitterLogin(); return false;">Twitter</a></p>
<p><a href="" onClick="gitHubLogin(); return false;">Github</a></p>
<p><a href="" onClick="signOut(); return false;">Signout</a></p>
</body>
</html>