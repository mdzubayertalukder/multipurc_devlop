
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-messaging.js');

firebase.initializeApp({
    apiKey: 'AIzaSyC16l26gttmBuRucVNBvEw8S_YKdjDs9eI',
    authDomain: 'multipurc.firebaseapp.com',
    projectId: 'multipurc',
    storageBucket: 'multipurc.appspot.com',
    messagingSenderId: '311815848948',
    appId: '1:311815848948:web:c39ab2333eb99d6252afa1',
    measurementId: 'G-5NRM8CFENF'
});
const messaging = firebase.messaging();
