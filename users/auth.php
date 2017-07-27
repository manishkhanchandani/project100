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
			userData.provider_id = 'google.com';
			
			console.log('userData is ', userData);
			
		}).catch(function(error) {
		  console.log('error is ', error);
		});
	}
	
	function facebookLogin() {
	
	}
	
	function twitterLogin() {
	
	}
	
	function gitHubLogin() {
	
	}
	
	function signOut() {
	
	}
</script>

</head>

<body>
<p>Firebase Authentication </p>
<p><a href="" onClick="googleLogin(); return false;">Google</a></p>
<p>Facebook</p>
<p>Twitter</p>
<p>GitHub </p>
</body>
</html>