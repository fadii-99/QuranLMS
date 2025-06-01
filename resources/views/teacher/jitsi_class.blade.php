@extends('layouts.admin')

@section('title', 'Live Class')

@section('content')
    <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-4">
        {{-- <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">
            Live Class: {{ $class->subject->name}}
        </h2> --}}
        <div id="jitsi-container" style="width: 100%; height: 90vh; border-radius: 10px; overflow: hidden;"></div>
    </div>
<script src='https://meet.jit.si/external_api.js'></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const domain = "meet.jit.si";
        const options = {
            roomName: "{{ $room }}",
            width: "100%",
            height: "100%",
            parentNode: document.getElementById('jitsi-container'),
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
                    'microphone', 'camera', 'desktop', 'chat', 'raisehand', 'tileview', 'hangup'
                ],
                filmStripOnly: false,
                DEFAULT_BACKGROUND: '#111827',
                HIDE_INVITE_MORE_HEADER: true,
                MOBILE_APP_PROMO: false,
            },
            configOverwrite: {
                disableDeepLinking: true,
                prejoinPageEnabled: false,
                startWithAudioMuted: false,
                startWithVideoMuted: false,
                enableWelcomePage: false,
                enableClosePage: true, // Show blank close page, not ad
                brandingRoomAlias: null,
                hideConferenceSubject: true,
                hideConferenceTimer: true,
                disableSimulcast: false,
                doNotStoreRoom: true,
                requireDisplayName: true,
                enableUserRolesBasedOnToken: false,
                SHOW_BRAND_WATERMARK: false,
                SHOW_POWERED_BY: false,
                SHOW_DEEP_LINKING_LOGO: false,
                SHOW_PROMOTIONAL_CLOSE_PAGE: false,
                SHOW_JITSI_WATERMARK: false,
            },
            userInfo: {
                displayName: "{{ $class->subject->name }}"
            }
        };
        const api = new JitsiMeetExternalAPI(domain, options);

        // Attempt to hide close page ads (not always possible)
        api.on('readyToClose', function () {
            // Try to redirect or hide ads when meeting ends
            window.location.href = "{{ route('teacher.class.index') }}"; // or any page you want
        });
    });
</script>

@endsection
