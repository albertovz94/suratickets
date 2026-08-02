importScripts('https://www.gstatic.com/firebasejs/9.22.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/9.22.0/firebase-messaging-compat.js');

const firebaseConfig = {
    apiKey: "AIzaSyB4q7MB2LMtTV_ziTMd6kyg4F1wMS3AcVw",
    authDomain: "surakihelpdesk.firebaseapp.com",
    projectId: "surakihelpdesk",
    storageBucket: "surakihelpdesk.firebasestorage.app",
    messagingSenderId: "1055509216576",
    appId: "1:1055509216576:web:4e4bf1f8eb7a4fce254ea5",
    measurementId: "G-B0NK0NVEPP"
};

firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();

messaging.onBackgroundMessage((payload) => {
    console.log('[firebase-messaging-sw.js] Notificación en segundo plano recibida: ', payload);
    const notificationTitle = payload.notification?.title || '🚨 Suraki HelpDesk';
    const notificationOptions = {
        body: payload.notification?.body || 'Nuevo ticket o actualización recibida.',
        icon: '/icono.png',
        badge: '/icono.png',
        tag: 'suraki-fcm-push'
    };

    self.registration.showNotification(notificationTitle, notificationOptions);
});
