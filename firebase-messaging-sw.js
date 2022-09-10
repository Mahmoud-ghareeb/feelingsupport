importScripts('https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.10.0/firebase-messaging.js');
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
*/
const firebaseConfig = {
    apiKey: "AIzaSyDRLjMy31iXQlOvRVxr1xOIX7PNbslq8PE",
    authDomain: "feelingsupport.firebaseapp.com",
    projectId: "feelingsupport",
    storageBucket: "feelingsupport.appspot.com",
    messagingSenderId: "286247524795",
    appId: "1:286247524795:web:2ab1344bec4b2ee50a8c9e",
    measurementId: "G-20QWXFYMMP"
    };

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function (payload) {
    console.log("Message received.", payload);
    const title = payload.data.title;
    const options = {
        body: payload.data.body,
        icon: payload.data.icon,
    };
    return self.registration.showNotification(
        title,
        options,
    );
});