<div>
    <x-template-form>
        <x-slot name='search'>
            <x-jet-input id="search" type="text" class="mt-1 block w-full" wire:model='search'
                placeholder="Buscar..." />
            <button wire:click='resetSearch' class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Reiniciar
            </button>
        </x-slot>
        <x-slot name='form'>
            <div class="m-2">
                <x-jet-label for="form_id" value="Depende del Formulario" />
                <select id="form_id" wire:model="form_id"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="">Seleccione un opcion</option>
                    @foreach ($forms as $form)
                        <option value="{{ $form->id }}">{{ $form->name }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="form_id" class="mt-2" />
            </div>

            @if ($form_id != null)
                <div class="m-2">
                    <x-jet-label for="question_id" value="Depende del Formulario" />
                    <select id="question_id" wire:model="question_id"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                        <option value="">Seleccione un opcion</option>
                        @foreach ($questions as $question)
                            <option value="{{ $question->id }}">{{ $question->name }}</option>
                        @endforeach
                    </select>
                    <x-jet-input-error for="question_id" class="mt-2" />
                </div>
            @endif

            @if ($question_id != null)
                <div class="m-2">
                    <x-jet-label for="textSearch" value="Nombre de la Formulario" />
                    <x-jet-input id="textSearch" type="text" class="mt-1 block w-full" wire:model='textSearch' />
                    <x-jet-input-error for="textSearch" class="mt-2" />
                </div>
            @endif

            <div class="m-2">
                <x-jet-danger-button wire:click="resetSearch">
                    Cancelar
                </x-jet-danger-button>
            </div>
        </x-slot>
        <x-slot name='table'>
            <table class="table w-full text-gray-400 border-separate space-y-6 text-sm">
                <thead class="bg-blue-500 text-white">
                    <tr class="uppercase">
                        <th class="p-3 text-left">Id</th>
                        <th class="p-3 text-left">Formulario</th>
                        <th class="p-3 text-left">Usuario</th>
                        <th class="p-3 text-left">Fecha</th>
                        <th class="p-3 text-left">Estado</th>
                        <th class="p-3 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $event)
                        <tr class="bg-blue-200 text-black">
                            <td class="p-3 ">
                                {{ $event->id }}
                            </td>
                            <td class="p-3">
                                {{ $event->form->name }}
                            </td>
                            <td class="p-3 ">
                                {{ $event->user->name }}
                            </td>
                            <td class="p-3 ">
                                {{ $event->created_at }}
                            </td>
                            <td class="p-3 ">
                                @if ($event->status == 1)
                                    <h1>Activo</h1>
                                @endif
                                @if ($event->status == 3)
                                    <h1>Finalizar</h1>
                                @endif
                            </td>
                            <td class="p-3 flex gap-1 items-center">
                                <x-tooltip tooltip="Eliminar">
                                    <a wire:click='modalDelete({{ $event->id }})' class="cursor-pointer">
                                        <x-fas-trash-can class="w-6 h-6 text-red-500 hover:text-gray-100" />
                                    </a>
                                </x-tooltip>
                                <x-tooltip tooltip="PDF">
                                    <a wire:click='exportPdf({{ $event->id }})' class="cursor-pointer">
                                        <x-fas-file-download class="w-6 h-6 text-blue-500 hover:text-gray-100" />
                                    </a>
                                </x-tooltip>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </x-slot>
        <x-slot name='paginate'>
            {{ $events->links() }}
        </x-slot>
    </x-template-form>
    <x-jet-dialog-modal wire:model="deleteModal">
        <x-slot name="title">
            <div class="flex col-span-6 sm:col-span-4 items-center">
                <x-fas-trash-can class="h-10 w-10 text-red-500 mr-2" />
                Eliminar Event
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="flex col-span-6 sm:col-span-4 items-center gap-2">
                <x-fas-keyboard class="h-20 w-20 text-yellow-500 text-center" />
                <p>
                    Una vez eliminado no se podra recuperar el registro.
                    ¿Esta seguro de que quiere eliminar el registro?
                </p>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-danger-button wire:click="$set('deleteModal', false)" wire:loading.attr="disabled">
                Cancelar
            </x-jet-danger-button>
            <x-jet-secondary-button class="ml-2" wire:click='delete' wire:loading.attr="disabled">
                Aceptar
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
