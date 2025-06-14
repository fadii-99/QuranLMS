@extends('layouts.admin')

@section('title', 'Live Class')

@section('content')
    <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-4">
        <div id="jitsi-container" style="width: 100%; height: 90vh; border-radius: 10px; overflow: hidden;"></div>
    </div>
    <script src="https://8x8.vc/vpaas-magic-cookie-2ae92a8bdbd74413a02fdf2c062dff0c/external_api.js"></script>
    <script type="text/javascript">
        function startJitsi() {
            if (window.JitsiMeetExternalAPI) {
                const domain = "8x8.vc";
                const options = {
                    roomName: "vpaas-magic-cookie-2ae92a8bdbd74413a02fdf2c062dff0c/{{ $room }}",
                    width: "100%",
                    height: "100%",
                    parentNode: document.getElementById('jitsi-container'),
                    // The JWT **must not** contain your name/email/avatar in the `context.user` claim
                    interfaceConfigOverwrite: {
                        SHOW_JITSI_WATERMARK: false,
                        SHOW_WATERMARK_FOR_GUESTS: false,
                        SHOW_BRAND_WATERMARK: false,
                        SHOW_POWERED_BY: false,
                        SHOW_DEEP_LINKING_LOGO: false,
                        DISPLAY_WELCOME_FOOTER: false,
                        DISPLAY_WELCOME_PAGE_ADDITIONAL_CARD: false,
                        SHOW_PROMOTIONAL_CLOSE_PAGE: false,
                        TOOLBAR_BUTTONS: [
                            'microphone', 'camera', 'desktop', 'chat', 'raisehand', 'tileview', 'recording',
                            'hangup'
                        ],
                        filmStripOnly: false,
                        DEFAULT_BACKGROUND: '#111827',
                        HIDE_INVITE_MORE_HEADER: true,
                        MOBILE_APP_PROMO: false,
                        HIDE_DEEP_LINKING_LOGO: true,
                        BRAND_WATERMARK_LINK: "",
                        JITSI_WATERMARK_LINK: "",
                        SUPPORT_URL: "",
                    },
                    configOverwrite: {
                        disableDeepLinking: true,
                        prejoinPageEnabled: false,
                        startWithAudioMuted: false,
                        startWithVideoMuted: false,
                        enableWelcomePage: false,
                        enableClosePage: false,
                        brandingRoomAlias: null,
                        hideConferenceSubject: true,
                        hideConferenceTimer: false,
                        disableSimulcast: false,
                        doNotStoreRoom: true,
                        requireDisplayName: false,
                        enableUserRolesBasedOnToken: true,
                        hideDisplayName: true, // <--- IMPORTANT: try to hide display name
                        disableProfile: true, // <--- disables editing user profile
                        enableLobbyChat: false,
                        gravatar: false, // <--- disables gravatar avatars
                        localRecording: {
                            enabled: true,
                            format: 'flv'
                        },
                        recordingService: {
                            enabled: true,
                            sharingEnabled: true
                        },
                        liveStreaming: {
                            enabled: true
                        },
                        showEmailInChat: false
                    },
                    userInfo: {
                        displayName: "{{ auth()->user()->name }}",
                        email: "",
                        avatar: ""
                    }
                };

                const api = new JitsiMeetExternalAPI(domain, options);

                api.on('readyToClose', function() {
                    fetch('{{ route('teacher.class.end', ['id' => $class->id]) }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            end: true
                        })
                    }).then(() => {
                        window.location.href = "{{ route('teacher.class.index') }}";
                    });
                });

                // Hide Jitsi branding and user info
                api.on('videoConferenceJoined', function() {
                    setTimeout(() => {
                        // Branding & watermark
                        const brandElements = document.querySelectorAll(
                            '[class*="brand"], [class*="logo"], [class*="watermark"], [class*="jitsi"]'
                        );
                        brandElements.forEach(el => {
                            el.style.display = 'none';
                        });

                        // User info in tiles, participant list, chat
                        const userInfoEls = document.querySelectorAll(
                            '[class*="display-name"], [class*="participant-info"], [class*="avatar"], [class*="email"], [data-testid*="participant-item"]'
                        );
                        userInfoEls.forEach(el => {
                            el.style.display = 'none';
                        });
                    }, 2000);
                });
            } else {
                setTimeout(startJitsi, 100);
            }
        }
        document.addEventListener("DOMContentLoaded", startJitsi);
    </script>
    <style>
        #jitsi-container .watermark,
        #jitsi-container .brand-watermark,
        #jitsi-container [class*="watermark"],
        #jitsi-container [class*="brand"],
        #jitsi-container [data-testid*="watermark"],

        #jitsi-container [class*="display-name"],
        #jitsi-container [class*="participant-info"],
        #jitsi-container [class*="avatar"],
        #jitsi-container [class*="email"],
        #jitsi-container [data-testid*="participant-item"] {
            display: none !important;
        }
    </style>
@endsection
