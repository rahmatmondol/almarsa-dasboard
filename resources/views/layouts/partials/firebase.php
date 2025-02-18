<script>
    const firebaseConfig = {
        apiKey: "<?php echo config('services.firebase.api_key'); ?>",
        authDomain: "<?php echo config('services.firebase.auth_domain'); ?>",
        databaseURL: "<?php echo config('services.firebase.database_url'); ?>",
        projectId: "<?php echo config('services.firebase.project_id'); ?>",
        storageBucket: "<?php echo config('services.firebase.storage_bucket'); ?>",
        messagingSenderId: "<?php echo config('services.firebase.messaging_sender_id'); ?>",
        appId: "<?php echo config('services.firebase.app_id'); ?>"
    };

    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    const database = firebase.database();
</script>