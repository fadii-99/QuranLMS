@extends('layouts.admin')

@section('title', 'Live Class')

@section('content')
    <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-4">
         <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">
            Live Class: {{ $class->subject->name}}
        </h2>
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
                    enableClosePage: false,
                    brandingRoomAlias: null,
                    hideConferenceSubject: true,
                    hideConferenceTimer: true,
                    disableSimulcast: false,
                    doNotStoreRoom: true,
                     requireDisplayName: true,
                      enableUserRolesBasedOnToken: false,
                    // Remove "invite people", branding, etc.
                },
                userInfo: {
                    displayName: "{{ auth()->user()->name }}"
                }
            };
            const api = new JitsiMeetExternalAPI(domain, options);

            // Remove branding and Jitsi links
            api.executeCommand('toggleLobby', false);
        });
    </script>
@endsection
