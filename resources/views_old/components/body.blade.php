<x-layout>
    @component('components.sidebar')
    @endcomponent

    <div class="wrapper d-flex flex-column">
        @component('components.header')
        @endcomponent

        <div class="body flex-grow-1">
            <div class="container-lg px-2">
                {{ $slot }}
            </div>
        </div>
    </div>

    @component('components.tag-script',['file'=>'vendors/coreui/coreui/js/coreui.bundle.min.js'])
    @endcomponent
    @component('components.tag-script',['file'=>'vendors/simplebar/js/simplebar.min.js'])
    @endcomponent
    @component('components.tag-script',['file'=>'vendors/coreui/utils/js/index.js'])
    @endcomponent
</x-layout>
