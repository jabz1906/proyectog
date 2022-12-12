<div>
    <div class="p-2 grid grid-cols-1 md:grid-cols-12 gap-2">
        <div class="col-span-1 md:col-span-4 bg-white border border-gray-200 rounded-lg shadow-md">
            <a href="#">
                <!-- <img class="rounded-t-lg" src="/docs/images/blog/image-1.jpg" alt="" /> -->
                <img src="{{ Storage::url('usuarios.png') }}" alt="" class="rounded-t-lg">
            </a>
            <div class="p-5">
                <a href="#">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">Usuarios</h5>
                </a>
                <p class="mb-3 font-normal text-gray-700">Existentes</p>
                <span class="text-xl font-bold text-gray-900">{{ $users->count() }}</span>
            </div>
        </div>

        <div class="col-span-1 md:col-span-4 bg-white border border-gray-200 rounded-lg shadow-md">
            <a href="#">
                <!-- <img class="rounded-t-lg" src="/docs/images/blog/image-1.jpg" alt="" /> -->
                <img src="{{ Storage::url('usuarios.png') }}" alt="" class="rounded-t-lg">
            </a>
            <div class="p-5">
                <a href="#">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">Usuarios</h5>
                </a>
                <p class="mb-3 font-normal text-gray-700">Activos</p>
                <span class="text-xl font-bold text-gray-900">{{ $users_active->count() }}</span>
            </div>
        </div>

        <div class="col-span-1 md:col-span-4 bg-white border border-gray-200 rounded-lg shadow-md">
            <a href="#">
                <!-- <img class="rounded-t-lg" src="/docs/images/blog/image-1.jpg" alt="" /> -->
                <img src="{{ Storage::url('usuarios.png') }}" alt="" class="rounded-t-lg">
            </a>
            <div class="p-5">
                <a href="#">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">Usuarios</h5>
                </a>
                <p class="mb-3 font-normal text-gray-700">Eliminados</p>
                <span class="text-xl font-bold text-gray-900">{{ $users_inactive->count() }}</span>
            </div>
        </div>

        <div class="col-span-1 md:col-span-4 bg-white border border-gray-200 rounded-lg shadow-md">
            <a href="#">
                <!-- <img class="rounded-t-lg" src="/docs/images/blog/image-1.jpg" alt="" /> -->
                <img src="{{ Storage::url('formularios.jpg') }}" alt="" class="rounded-t-lg">
            </a>
            <div class="p-5">
                <a href="#">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">Formularios</h5>
                </a>
                <p class="mb-3 font-normal text-gray-700">Formularios Existentes</p>
                <span class="text-xl font-bold text-gray-900">{{ $forms->count() }}</span>
            </div>
        </div>

        <div class="col-span-1 md:col-span-4 bg-white border border-gray-200 rounded-lg shadow-md">
            <a href="#">
                <!-- <img class="rounded-t-lg" src="/docs/images/blog/image-1.jpg" alt="" /> -->
                <img src="{{ Storage::url('formularios.jpg') }}" alt="" class="rounded-t-lg">
            </a>
            <div class="p-5">
                <a href="#">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">Formularios</h5>
                </a>
                <p class="mb-3 font-normal text-gray-700">Formularios Llenados</p>
                <span class="text-xl font-bold text-gray-900">{{ $events->count() }}</span>
            </div>
        </div>

        <div class="col-span-1 md:col-span-4 bg-white border border-gray-200 rounded-lg shadow-md">
            <a href="#">
                <!-- <img class="rounded-t-lg" src="/docs/images/blog/image-1.jpg" alt="" /> -->
                <img src="{{ Storage::url('formularios.jpg') }}" alt="" class="rounded-t-lg">
            </a>
            <div class="p-5">
                <a href="#">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">Formularios</h5>
                </a>
                <p class="mb-3 font-normal text-gray-700">Formularios eliminados</p>
                <span class="text-xl font-bold text-gray-900">{{ $events_inctive->count() }}</span>
            </div>
        </div>
    </div>
</div>
