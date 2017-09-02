<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>display</title>
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
		  console.log('auth user: ', user);
		var userData = {};
		userData.displayName = user.displayName;
		userData.email = user.email;
		userData.photoURL = user.photoURL;
		userData.profileUID = user.providerData[0].uid;
		userData.refreshToken = user.refreshToken;
		userData.uid = user.uid;
		
		console.log('userData2 is ', userData);
	  } else {
		console.log('user is logged out');
	  }
	});
	
	function postToApi(obj) {
		//i want to send the obj i.e. userData to userApi.php
		
		console.log('obj is ', obj);
		//AJAX - we pass the data to backend without page refresh
		
	}


	function googleLogin() {
		var provider = new firebase.auth.GoogleAuthProvider();
		firebase.auth().signInWithPopup(provider).then(function(result) {
		
			var user = result.user;
		  	console.log('user is ', user);
			
			var userData = {};
			userData.displayName = user.displayName;
			userData.email = user.email;
			userData.photoURL = user.photoURL;
			userData.profileUID = user.providerData[0].uid;
			userData.refreshToken = user.refreshToken;
			userData.uid = user.uid;
			userData.provider_id = user.providerData[0].providerId;
			
			console.log('userData is ', userData);
			//something to pass userData to backend php api
			postToApi(userData);
		}).catch(function(error) {
		  console.log('error is ', error);
		});
	}
	
	function facebookLogin() {
		var provider = new firebase.auth.FacebookAuthProvider();
		firebase.auth().signInWithPopup(provider).then(function(result) {
		  
			var user = result.user;
		  	console.log('user is ', user);
			
			var userData = {};
			userData.displayName = user.displayName;
			userData.email = user.email;
			userData.photoURL = user.photoURL;
			userData.profileUID = user.providerData[0].uid;
			userData.refreshToken = user.refreshToken;
			userData.uid = user.uid;
			userData.provider_id = user.providerData[0].providerId;
			
			console.log('userData is ', userData);
		}).catch(function(error) {
		  console.log('error is ', error);
		});
	}
	
	//https://apps.twitter.com/
	function twitterLogin() {
		var provider = new firebase.auth.TwitterAuthProvider();
		firebase.auth().signInWithPopup(provider).then(function(result) {
		  var user = result.user;
		  	console.log('user is ', user);
			
			var userData = {};
			userData.displayName = user.displayName;
			userData.email = user.email;
			userData.photoURL = user.photoURL;
			userData.profileUID = user.providerData[0].uid;
			userData.refreshToken = user.refreshToken;
			userData.uid = user.uid;
			userData.provider_id = user.providerData[0].providerId;
			
			console.log('userData is ', userData);
		}).catch(function(error) {
		  console.log('error is ', error);
		});
	}
	
	//https://github.com/settings/developers
	function gitHubLogin() {
		var provider = new firebase.auth.GithubAuthProvider();
		
		firebase.auth().signInWithPopup(provider).then(function(result) {
 			var user = result.user;
		  	console.log('user is ', user);
			
			var userData = {};
			userData.displayName = user.displayName;
			userData.email = user.email;
			userData.photoURL = user.photoURL;
			userData.profileUID = user.providerData[0].uid;
			userData.refreshToken = user.refreshToken;
			userData.uid = user.uid;
			userData.provider_id = user.providerData[0].providerId;
			
			console.log('userData is ', userData);
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