<div>
    <x-template-form>
        <x-slot name='search'>
            <x-jet-input id="search" type="text" class="mt-1 block w-full" wire:model='search' placeholder="Buscar..." />
            <button wire:click='resetSearch'
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Reiniciar
            </button>
        </x-slot>
        <x-slot name='form'>
            <div class="m-2">
                @if ($action == 'create')
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Nuevo Formulario
                    </h2>
                @else
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Editar Formulario
                    </h2>
                @endif
            </div>
            <div class="flex m-2 gap-2">
                @if ($action == 'create')
                    @if ($image)
                        <div>
                            Imagen Preview:
                            <img src="{{ $image->temporaryUrl() }}" class="rounded-full h-20 w-20 object-cover">
                        </div>
                    @endif
                @else
                    <div>
                        Imagen Anterior
                        <img src="{{ Storage::url($imageBefore) }}" alt="{{ $name }}"
                            class="rounded-full h-20 w-20 object-cover">
                    </div>
                    <div>
                        @if ($image)
                            Imagen Nueva
                            <img src="{{ $image->temporaryUrl() }}" class="rounded-full h-20 w-20 object-cover">
                        @endif
                    </div>

                @endif
            </div>
            <div class="m-2">
                <x-jet-label for="parent_id" value="Depende del Formulario" />
                <select id="parent_id" wire:model="parent_id"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="null">Seleccione un opcion</option>
                    @foreach ($forms as $form)
                        @if ($action == 'create')
                            <option value="{{ $form->id }}">{{ $form->name }}</option>
                        @else
                            @if ($form->id != $form_id)
                                <option value="{{ $form->id }}">{{ $form->name }}</option>
                            @endif
                        @endif
                    @endforeach
                </select>
                <x-jet-input-error for="parent_id" class="mt-2" />
            </div>
            <div class="m-2">
                <x-jet-label for="name" value="Nombre de la Formulario" />
                <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model='name' />
                <x-jet-input-error for="name" class="mt-2" />
            </div>
            <div class="m-2">
                <x-jet-label for="description" value="Descripcion del Formulario" />
                <textarea id="description" wire:model.defer='description'
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                    rows="4"></textarea>
                <x-jet-input-error for="description" class="mt-2" />
            </div>
            <div class="m-2">
                <x-jet-label for="image" value="Image" />
                <x-jet-input id="upload{{ $iteration }}" type="file" accept=".bmp, .png, .jpg"
                    class="mt-1 block w-full" wire:model='image' />
                <x-jet-input-error for="image" class="mt-2" />
            </div>
            <div class="m-2">
                <x-jet-danger-button wire:click="clear">
                    Cancelar
                </x-jet-danger-button>
                @if ($action == 'create')
                    <x-jet-secondary-button wire:click='store'>
                        Guardar
                    </x-jet-secondary-button>
                @else
                    <x-jet-secondary-button wire:click='update'>
                        Actualizar
                    </x-jet-secondary-button>
                @endif
            </div>
        </x-slot>
        <x-slot name='table'>
            <table class="table w-full text-gray-400 border-separate space-y-6 text-sm">
                <thead class="bg-blue-500 text-white">
                    <tr class="uppercase">
                        <th class="p-3 text-left">Imagen</th>
                        <th class="p-3 text-left">Formulario</th>
                        <th class="p-3 text-left">Descripcion</th>
                        <th class="p-3 text-left">Dependiente</th>
                        <th class="p-3 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($forms as $form)
                        <tr class="bg-blue-200 text-black">
                            <td class="p-3">
                                <img src="{{ Storage::url($form->image) }}" alt="{{ $form->name }}"
                                    class="rounded-full h-10 w-10 object-cover" data-action="zoom">
                            </td>
                            <td class="p-3 ">
                                {{ $form->name }}
                            </td>
                            <td class="p-3 ">
                                {{ $form->description }}
                            </td>
                            <td class="p-3 ">
                                @foreach ($form->forms as $child)
                                    {{ $child->name }}
                                @endforeach
                            </td>
                            <td class="p-3 flex gap-1 items-center">
                                <x-tooltip tooltip="Editar">
                                    <a wire:click='edit({{ $form->id }})' class="cursor-pointer">
                                        <x-fas-pen-to-square class="w-6 h-6 text-green-500 hover:text-gray-100" />
                                    </a>
                                </x-tooltip>
                                <x-tooltip tooltip="Eliminar">
                                    <a wire:click='modalDelete({{ $form->id }})' class="cursor-pointer">
                                        <x-fas-trash-can class="w-6 h-6 text-red-500 hover:text-gray-100" />
                                    </a>
                                </x-tooltip>
                                <x-tooltip tooltip="Preguntas">
                                    <a href="{{ route('page.question', $form->id) }}" class="cursor-pointer">
                                        <x-fas-arrow-alt-circle-right
                                            class="w-6 h-6 text-blue-500 hover:text-gray-100" />
                                    </a>
                                </x-tooltip>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </x-slot>
        <x-slot name='paginate'>
            {{ $forms->links() }}
        </x-slot>
    </x-template-form>
    <x-jet-dialog-modal wire:model="deleteModal">
        <x-slot name="title">
            <div class="flex col-span-6 sm:col-span-4 items-center">
                <x-fas-trash-can class="h-10 w-10 text-red-500 mr-2" />
                Eliminar Formulario
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
