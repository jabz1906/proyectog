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
            <div class="flex m-2">
                @if ($action == 'create')
                    <h2 class="w-full font-semibold text-xl text-gray-800 leading-tight">
                        Nueva Pregunta
                    </h2>
                @else
                    <h2 class="w-full font-semibold text-xl text-gray-800 leading-tight">
                        Editar Pregunta
                    </h2>
                @endif
                <x-tooltip tooltip="Atras">
                    <a href="{{ route('page.form') }}" class="cursor-pointer">
                        <x-fas-arrow-alt-circle-left class="w-6 h-6 text-blue-500 hover:text-gray-100" />
                    </a>
                </x-tooltip>
            </div>
            <div class="m-2">
                <x-jet-label for="name_form" value="Formulario" />
                <x-jet-input id="name_form" type="text" class="mt-1 block w-full" wire:model='name_form'
                    disabled="true" />
            </div>
            <div class="m-2">
                <x-jet-label for="type_id" value="Tipo de pregunta" />
                <select id="type_id" wire:model="type_id"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="null">Seleccione un opcion</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="type_id" class="mt-2" />
            </div>
            <div class="m-2">
                <x-jet-label for="name" value="Nombre de la Pregunta" />
                <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model='name' />
                <x-jet-input-error for="name" class="mt-2" />
            </div>
            <div class="m-2">
                <x-jet-label for="mandatory" value="Obligatorio" />
                <select id="mandatory" wire:model="mandatory"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="null">Seleccione un opcion</option>
                    <option value="1">Si</option>
                    <option value="0">No</option>
                </select>
                <x-jet-input-error for="mandatory" class="mt-2" />
            </div>
            <div class="m-2">
                <x-jet-label for="order" value="Orden" />
                <x-jet-input id="order" type="number" class="mt-1 block w-full" wire:model='order' />
                <x-jet-input-error for="order" class="mt-2" />
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
                        <th class="p-3 text-left">Orden</th>
                        <th class="p-3 text-left">Tipo</th>
                        <th class="p-3 text-left">Pregunta</th>
                        <th class="p-3 text-left">Obligatorio</th>
                        <th class="p-3 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($questions as $question)
                        <tr class="bg-blue-200 text-black">
                            <td class="p-3 ">
                                {{ $question->order }}
                            </td>
                            <td class="p-3 ">
                                {{ $question->type->name }}
                            </td>
                            <td class="p-3 ">
                                {{ $question->name }}
                                <br>
                                <span class="text-gray-500">{{ $question->description }}</span>
                            </td>
                            <td class="p-3 ">
                                @if ($question->mandatory == 1)
                                    SI
                                @else
                                    NO
                                @endif
                            </td>
                            <td class="p-3 flex gap-1 items-center">
                                <x-tooltip tooltip="Editar">
                                    <a wire:click='edit({{ $question->id }})' class="cursor-pointer">
                                        <x-fas-pen-to-square class="w-6 h-6 text-green-500 hover:text-gray-100" />
                                    </a>
                                </x-tooltip>
                                <x-tooltip tooltip="Eliminar">
                                    <a wire:click='modalDelete({{ $question->id }})' class="cursor-pointer">
                                        <x-fas-trash-can class="w-6 h-6 text-red-500 hover:text-gray-100" />
                                    </a>
                                </x-tooltip>
                                @if ($question->type->features == true)
                                @if ($question->type->id != 10)
                                    <x-tooltip tooltip="Opciones">
                                        <a href="{{ route('page.option', $question->id) }}" class="cursor-pointer">
                                            <x-fas-arrow-alt-circle-right
                                                class="w-6 h-6 text-blue-500 hover:text-gray-100" />
                                        </a>
                                    </x-tooltip>
                                    @endif
                                    @if ($question->type->id == 10)
                                        <x-tooltip tooltip="Opciones Especiales">
                                            <a href="{{ route('page.special', $question->id) }}"
                                                class="cursor-pointer">
                                                <x-fas-arrow-alt-circle-right
                                                    class="w-6 h-6 text-orange-500 hover:text-gray-100" />
                                            </a>
                                        </x-tooltip>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </x-slot>
        <x-slot name='paginate'>
            {{ $questions->links() }}
        </x-slot>
    </x-template-form>
    <x-jet-dialog-modal wire:model="deleteModal">
        <x-slot name="title">
            <div class="flex col-span-6 sm:col-span-4 items-center">
                <x-fas-trash-can class="h-10 w-10 text-red-500 mr-2" />
                Eliminar Pregunta
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
