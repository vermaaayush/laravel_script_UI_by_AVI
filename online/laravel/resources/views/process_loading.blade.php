 <!-- Header -->
 @include('header')
 <!-- // Header -->

 <!-- Sidebar -->
@include('sidebar')
 <!-- //  Sidebar -->

 <!-- top navbar -->
@include('topNav')
 <!-- // top navbar -->
         

<!-- Main Content Wrapper -->
<div class="max-w-4xl mx-auto w-full">
    <!-- Header -->
    <div class="mb-lg">
        <div class="flex items-center gap-sm text-on-surface-variant text-body-md font-body-md mb-xs">
            <a class="hover:text-primary transition-colors" href="#">Transfer</a>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <span class="text-on-surface font-medium">Processing Transfer</span>
        </div>
        <h2 class="text-display-lg font-display-lg text-on-surface mb-xs">Processing Transfer</h2>
        <p class="text-body-lg font-body-lg text-on-surface-variant">Please wait while your transfer is being securely processed. Do not close or refresh this page.</p>
    </div>

    <!-- Content -->
    <div class="flex flex-col gap-md">
        <div class="bg-surface rounded-xl shadow-level-1 p-lg flex flex-col gap-xl border border-outline-variant/20 items-center justify-center min-h-[450px]">
            
            <!-- animation widget by aayush -->
            <div id="sectionA" class="w-full text-center">

                <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script> 

                <dotlottie-player src="https://lottie.host/20c4526c-864f-460b-8e63-85ebf6736d15/GJ3TKMrgid.json" background="transparent" speed="1" style="width: 250px; height: 250px; margin: auto" loop autoplay></dotlottie-player>
                
                <div class="mt-8">
                   <h5 id="animate_text" class="text-primary font-bold text-headline-sm text-center tracking-wide uppercase"></h5>
                </div>

                <script>
                    const loadingTexts = [
                        "TRANSFER FORM SUBMITTED",
                        "PLEASE WAIT...........",
                        "YOUR TRANSFER DATA IS BEING PROCESSED",
                        "ACCOUNT NUMBER VERIFIED",
                        "TRANSFER DATA PROCESSED ::: PORTAL OPENED",
                        "INITIATING TRANSFER",
                        "10% OF TRANSFER COMPLETED",
                        "12% OF TRANSFER COMPLETED",
                        "15% OF TRANSFER COMPLETED",
                        "28% OF TRANSFER COMPLETED",
                        "59% OF TRANSFER COMPLETED",
                        "99% OF TRANSFER COMPLETED",
                    ];

                    const animate_text = document.getElementById('animate_text');

                    function updateLoadingText(index) {
                        animate_text.textContent = loadingTexts[index];
                    }

                    function updateTextSequentially(index) {
                        updateLoadingText(index);
                        setTimeout(() => {
                            if (index < loadingTexts.length - 1) {
                                updateTextSequentially(index + 1);
                            } else {
                                // Dynamically route instead of hardcoded 127.0.0.1
                                window.location.href = window.location.origin + '/online/done';
                            }
                        }, 2000);
                    }

                    // Start the animation
                    setTimeout(() => {
                        updateTextSequentially(0);
                    }, 1500);
                </script>

            </div>
            <!-- animation widget by aayush -->
             
        </div>
    </div>
</div>
<!-- // Page Content -->

<!-- footer -->
@include('footer')
<!-- // footer -->
