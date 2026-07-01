<x-app-layout>

<div class="min-h-screen bg-slate-100 p-6">

    <div class="max-w-2xl mx-auto">

        {{-- CARD --}}
        <div class="bg-white rounded-3xl shadow-lg border border-slate-200 p-6">

            {{-- HEADER --}}
            <div class="mb-6">
                <h2 class="text-2xl font-extrabold text-slate-800">
                    Novo Produto
                </h2>
                <p class="text-sm text-slate-500">
                    Preencha os dados do produto
                </p>
            </div>

            {{-- ERROS --}}
           @if ($errors->any())
    <div class="mb-5 border-l-4 border-red-600 bg-red-50 p-4 rounded-2xl shadow-sm">

        <div class="flex items-center gap-2 text-red-700 font-bold mb-2">
            <span>⚠</span>
            <span>Erro ao guardar o produto</span>
        </div>

        <ul class="list-disc pl-5 space-y-1 text-sm text-red-700">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>

    </div>
@endif

            {{-- FORM --}}
            <form method="POST" action="{{ route('products.store') }}" class="space-y-5">
                @csrf

                {{-- Nome --}}
              <div>
    <label class="block text-sm font-semibold text-slate-700">
        Nome do Produto
    </label>

    <input type="text" name="name" value="{{ old('name') }}"
        class="w-full mt-1 p-3 rounded-xl shadow-sm border
        @error('name') border-red-500 focus:border-red-600 focus:ring-red-600 @else border-slate-300 focus:border-green-600 focus:ring-green-600 @enderror"
        placeholder="Ex: Arroz 5kg">

    @error('name')
        <p class="text-red-600 text-sm mt-1"> {{ $message }} </p>
    @enderror
</div>

                {{-- Preço --}}
             <div>
    <label class="block text-sm font-semibold text-slate-700">
        Preço
    </label>

    <input type="number" step="0.01" name="price" value="{{ old('price') }}"
        class="w-full mt-1 p-3 rounded-xl shadow-sm border
        @error('price') border-red-500 focus:border-red-600 focus:ring-red-600 @else border-slate-300 focus:border-green-600 focus:ring-green-600 @enderror"
        placeholder="Ex: 250.00">

    @error('price')
        <p class="text-red-600 text-sm mt-1"> {{ $message }} </p>
    @enderror
</div>

                {{-- Stock --}}
               <div>
    <label class="block text-sm font-semibold text-slate-700">
        Quantidade em Stock
    </label>

    <input type="number" name="quantity" value="{{ old('quantity') }}"
        class="w-full mt-1 p-3 rounded-xl shadow-sm border
        @error('quantity') border-red-500 focus:border-red-600 focus:ring-red-600 @else border-slate-300 focus:border-green-600 focus:ring-green-600 @enderror"
        placeholder="Ex: 100">

    @error('quantity')
        <p class="text-red-600 text-sm mt-1"> {{ $message }} </p>
    @enderror
</div>

                {{-- BOTÃO --}}
                <button type="submit"
                    class="w-full bg-green-700 hover:bg-green-800 text-black font-bold py-3 rounded-2xl shadow-lg">
                    GUARDAR PRODUTO
                </button>

            </form>

        </div>

    </div>

</div>

</x-app-layout>