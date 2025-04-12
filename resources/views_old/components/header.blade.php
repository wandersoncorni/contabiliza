<header class="header header-sticky p-0 mb-4">
    <div class="container-fluid border-bottom px-4">
        <button class="header-toggler" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()" style="margin-inline-start: -14px;">
            @component('components.tag-svg',['file'=>'/vendors/coreui/icons/svg/free.svg#cil-menu'])
            @endcomponent
        </button>
        <ul class="header-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <svg class="icon icon-lg">
                        <use xlink:href="/vendors/coreui/icons/svg/free.svg#cil-bell"></use>
                    </svg>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <svg class="icon icon-lg">
                        <use xlink:href="/vendors/coreui/icons/svg/free.svg#cil-envelope-open"></use>
                    </svg>
                </a>
            </li>
        </ul>
        <ul class="header-nav">
            <li class="nav-item py-1">
                <div class="vr h-100 mx-2 text-body text-opacity-75"></div>
            </li>
            <li class="nav-item dropdown">
                <button class="btn btn-link nav-link py-2 px-2 d-flex align-items-center" type="button" aria-expanded="false" data-coreui-toggle="dropdown">
                    <svg class="icon icon-lg theme-icon-active">
                        <use xlink:href="/vendors/coreui/icons/svg/free.svg#cil-contrast"></use>
                    </svg>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" style="--cui-dropdown-min-width: 8rem;">
                    <li>
                        <button class="dropdown-item d-flex align-items-center" type="button" data-coreui-theme-value="light">
                            <svg class="icon icon-lg me-3">
                                <use xlink:href="/vendors/coreui/icons/svg/free.svg#cil-sun"></use>
                            </svg>Light
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item d-flex align-items-center" type="button" data-coreui-theme-value="dark">
                            <svg class="icon icon-lg me-3">
                                <use xlink:href="/vendors/coreui/icons/svg/free.svg#cil-moon"></use>
                            </svg>Dark
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item d-flex align-items-center active" type="button" data-coreui-theme-value="auto">
                            <svg class="icon icon-lg me-3">
                                <use xlink:href="/vendors/coreui/icons/svg/free.svg#cil-contrast"></use>
                            </svg>Auto
                        </button>
                    </li>
                </ul>
            </li>
            <li class="nav-item py-1">
                <div class="vr h-100 mx-2 text-body text-opacity-75"></div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link py-0 pe-0" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <div class="avatar avatar-md">
                        <img class="avatar-img" src="
                        @if(!is_null(Auth::user()->atributos) && isset(Auth::user()->attributos['avatar']))
                        ''
                        @else
                        data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAAAAAByaaZbAAAAIGNIUk0AAHomAACAhAAA+gAAAIDoAAB1MAAA6mAAADqYAAAXcJy6UTwAAAACYktHRAD/h4/MvwAAAAd0SU1FB+gIGhEhDKHaX/oAAAP0SURBVEjHjVZbb9xEFPZ/xd7dsCFtEtgUIkCiQtAHeIBC+gCoL0AfaAVCVXkoakI3SZPNQlSJS0iTRkpTFYjt8dxnPPZwfK292RIszT7sd86c853LZzs2jUJjcaAt9aXlPrcyoFYH2JoQJQmqwKAAlZMajOKEhCploUx5yFMZ0lQjksQoMibKQKRTWoLKiXBsSKQMRTLhSCQCsURG1OiImBjnoDY0kgkrQCdEJsFhdoWyLBBWBMyqkNkkIolBORinpAapY2KCdQxXGBYJwyNuJGHo8cOHj/5GLC5ArACUBejAVXBFzSvglo2uvzPf719YvrqKLVQkhQRqUDmYKA1XxAzLmGMRy/1rs67rdTqe5/beH6mYkuegwMwJ4IooiC0JIE1f2PHrbqd+3Fdua+BQgCUHrSiVmhGpORFajhYb9hCm963IQQYgJ1wDhxQ1Gnf0RssePPpbra4qhzKpGJWKU6E4/mzCHrJ6+0SBgcgNBOWOHyY25+ArK36e8yYdOt53SQ5mBIVPHSk5E+WRN84EgBDvBbwy4FJkHALg4GelRlemOHgXfw2bHDgXojzyZOlsRp1Od1NVRvDT4vD44jQHb7XFoRFBHcxPdbirmxFKDvksHQ+mprSKmhykZKyqVPDuNNJzv4tmlYIGB359Wlkvk3rQMg4wSXmns2bKX2anRLjV7nRLBPTKS2cCLD8jLRHQGga+Gkjz5yRtb+YubERzWgOUrVQ18nKzPU1e5yt/Yh8wyZe2Wiq91lwId+ZLnIG0sXHFTpN6bcXeBz03j+K53ls/+Whyp3PVAOHJhEGAIvEU3b+61O92Zxau3H5mSClbz1WjoUupOD3kmSbxw93x9ta+SDFK4qNTkxbCKFIRUgdFubglFKl079OFa48gjoq4NYRCcBrcGny8l4G18iWFtoI5vvOq67mDm4fQ0jiiaULwP/cuA5WF71lDWysHrb6Zybh63uJHP/xxfPTkr/0fP3+z6+bScUOw2qFKidzslR2A6vQXL10azHXc6p/u13xSjO39frNjHjytfq/ZinRRVnawPGVQGx5Le6olxtEX/2kPPV9htRjDaNDfpm5zM8TsDi3FOOt9cF4ACPHJaSnGMN76ycA7z8GbP5ClGEdhunaeeeZxRxZiDOtJV87NCHL6kOhsRTMROFk+NyOI8NrTUoyZ2L/wPxw6L++KUoyjXRj/Xq9b/LzodHv3UCnG8un69nhzuDV+MHww3hpujreHG+PRcGNntL4+2lkfjsYbw8zgWFZiDHtiOYqtRMpqJKxBDIpHrMXYWhKlliFjBZKTYlzp7YvPhBhXXzN+/TWTtt6YhZCpUijL1yLlmR4qSVl+zoL/AjxuwZ3iXAn7AAAAJXRFWHRkYXRlOmNyZWF0ZQAyMDI0LTA4LTI2VDE3OjMzOjAwKzAwOjAwTJgreAAAACV0RVh0ZGF0ZTptb2RpZnkAMjAyNC0wOC0yNlQxNzozMzowMCswMDowMD3Fk8QAAAAodEVYdGRhdGU6dGltZXN0YW1wADIwMjQtMDgtMjZUMTc6MzM6MTIrMDA6MDAx5aOsAAAAAElFTkSuQmCC
                        @endif
                        " alt="">
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <a class="dropdown-item" href="/profile">
                        <svg class="icon me-2">
                            <use xlink:href="/vendors/coreui/icons/svg/free.svg#cil-user"></use>
                        </svg> Profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/logout">
                        <svg class="icon me-2">
                            <use xlink:href="/vendors/coreui/icons/svg/free.svg#cil-account-logout"></use>
                        </svg> Sair
                    </a>
                </div>
            </li>
        </ul>
    </div>
    <div class="container-fluid px-4">
        {{--@include('menubuilder::breadcrumb')--}}
        <div>{{session('nome_cliente')}}</div>
        <div class="submenu">
            @stack('submenu')
        </div>
    </div>
</header>
