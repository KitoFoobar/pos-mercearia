<nav class="bg-white border-b border-gray-200 shadow-sm">

    <div class="px-6">

        <div class="flex justify-between items-center h-16">

            {{-- Logo --}}
            <div class="flex items-center gap-3">

                <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white font-bold">
                    SB
                </div>

                <div>
                    <h1 class="font-bold text-gray-800">
                        STOCKBAR PRO
                    </h1>

                    <p class="text-xs text-gray-500">
                        Gestão de Vendas & Stock
                    </p>
                </div>

            </div>

            {{-- Menu --}}
            <div class="hidden md:flex items-center gap-4">

                <a href="{{ route('dashboard') }}"
                   class="px-4 py-2 rounded-lg hover:bg-gray-100">
                    📊 Dashboard
                </a>

                <a href="{{ route('pos') }}"
                   class="px-4 py-2 rounded-lg hover:bg-gray-100">
                    🛒 POS
                </a>

                <a href="{{ route('products.index') }}"
                   class="px-4 py-2 rounded-lg hover:bg-gray-100">
                    📦 Produtos
                </a>

                <a href="{{ route('sales.index') }}"
                   class="px-4 py-2 rounded-lg hover:bg-gray-100">
                    💰 Vendas
                </a>

            </div>

            {{-- Utilizador --}}
            <div class="flex items-center gap-3">

                <div class="text-right">

                    <div class="font-semibold text-gray-800">
                        {{ Auth::user()->name }}
                    </div>

                    <div class="text-xs text-gray-500">
                        Administrador
                    </div>

                </div>

                <form method="POST"
                      action="{{ route('logout') }}">
                    @csrf

                    <button
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                        Sair
                    </button>

                </form>

            </div>

        </div>

    </div>

</nav>