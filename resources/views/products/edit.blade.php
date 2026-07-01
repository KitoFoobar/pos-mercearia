<x-app-layout>

<div class="min-h-screen bg-slate-100 p-6">

    <div class="max-w-2xl mx-auto">

        {{-- CARD --}}
        <div class="bg-white rounded-3xl shadow-lg border border-slate-200 p-6">

            {{-- HEADER --}}
            <div class="mb-6">
                <h2 class="text-2xl font-extrabold text-slate-800">
                    Editar Produto
                </h2>
                <p class="text-sm text-slate-500">
                    Atualize dados ou adicione/remove stock
                </p>
            </div>

            {{-- ERROS --}}
            @if ($errors->any())
                <div class="mb-5 border-l-4 border-red-600 bg-red-50 p-4 rounded-2xl shadow-sm">

                    <div class="flex items-center gap-2 text-red-700 font-bold mb-2">
                        <span>⚠</span>
                        <span>Erro ao atualizar produto</span>
                    </div>

                    <ul class="list-disc pl-5 space-y-1 text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>
            @endif

            {{-- FORM --}}
            <form method="POST" action="{{ route('products.update', $product) }}" class="space-y-5">

                @csrf
                @method('PUT')

                {{-- NOME --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700">
                        Nome do Produto
                    </label>

                    <input type="text" name="name"
                        value="{{ old('name', $product->name) }}"
                        class="w-full mt-1 p-3 rounded-xl border
                        @error('name') border-red-500 focus:border-red-600 focus:ring-red-600 @else border-slate-300 focus:border-green-600 focus:ring-green-600 @enderror"
                        placeholder="Ex: Arroz 5kg">

                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- PREÇO --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700">
                        Preço
                    </label>

                    <input type="number" step="0.01" name="price"
                        value="{{ old('price', $product->price) }}"
                        class="w-full mt-1 p-3 rounded-xl border
                        @error('price') border-red-500 focus:border-red-600 focus:ring-red-600 @else border-slate-300 focus:border-green-600 focus:ring-green-600 @enderror"
                        placeholder="Ex: 250.00">

                    @error('price')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- STOCK (INCREMENTO) --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700">
                        Alterar Stock (usar + ou -)
                    </label>

                    <input type="number" name="quantity" value="0"
                        class="w-full mt-1 p-3 rounded-xl border border-slate-300
                        focus:border-green-600 focus:ring-green-600"
                        placeholder="Ex: 10 ou -5">

                    <p class="text-xs text-slate-500 mt-1">
                        Stock atual: <strong>{{ $product->quantity }}</strong>
                    </p>

                    @error('quantity')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- BOTÃO --}}
                <button type="submit"
                    class="w-full bg-blue-700 hover:bg-blue-800 text-white font-bold py-3 rounded-2xl shadow-lg">
                    ATUALIZAR PRODUTO
                </button>

            </form>

        </div>

    </div>

</div>

</x-app-layout>