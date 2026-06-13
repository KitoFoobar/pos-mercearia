<x-app-layout>

<div class="min-h-screen bg-slate-100 p-4">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        {{-- ================= PRODUTOS ================= --}}
        <div class="lg:col-span-2 bg-white rounded-3xl shadow-md p-4">

            <div class="flex justify-between items-center mb-4">

                <h2 class="text-2xl font-bold">🛒 POS Rápido</h2>

                <input id="search"
                       onkeyup="filterProducts()"
                       placeholder="Pesquisar produto..."
                       class="border rounded-xl px-3 py-2 w-1/2">

            </div>

            <div id="products" class="grid grid-cols-2 md:grid-cols-3 gap-3">

                @foreach($products as $product)

                    <button
                        data-name="{{ strtolower($product->name) }}"
                        onclick="add({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, {{ $product->quantity }})"
                        class="product bg-slate-50 hover:bg-indigo-50 border rounded-2xl p-3 text-left transition">

                        <div class="font-bold">{{ $product->name }}</div>
                        <div class="text-indigo-600 font-semibold">{{ $product->price }} MZN</div>
                        <div class="text-xs text-gray-500">Stock: {{ $product->quantity }}</div>

                    </button>

                @endforeach

            </div>

        </div>

        {{-- ================= CARRINHO ================= --}}
        <div class="bg-white rounded-3xl shadow-md p-4 flex flex-col h-[85vh]">

            <h2 class="text-xl font-bold mb-3">🧾 Carrinho</h2>

            <div id="cart" class="flex-1 space-y-2 overflow-y-auto pr-1"></div>

            <div class="border-t pt-3 mt-3 bg-white">

                {{-- TOTAL --}}
                <div class="flex justify-between text-xl font-bold">
                    <span>Total</span>
                    <span id="total"
                          class="text-2xl font-bold text-emerald-700 transition duration-150">
                        0 MZN
                    </span>
                </div>

                {{-- DINHEIRO --}}
                <input id="cash"
                       type="number"
                       placeholder="Dinheiro recebido"
                       oninput="calcChange()"
                       class="w-full border rounded-xl mt-3 p-2">

                {{-- TROCO --}}
                <div class="flex justify-between mt-2 text-lg">
                    <span>Troco</span>
                    <span id="change">0 MZN</span>
                </div>

                {{-- BOTÃO FINAL --}}
                <div class="mt-4 p-4 rounded-2xl bg-gradient-to-r from-emerald-600 to-green-700 shadow-xl">

                    <button onclick="checkout()"
                            class="w-full text-black font-bold text-lg py-4 rounded-xl
                                   tracking-wide hover:scale-[1.02] active:scale-95 transition">

                        💳 FINALIZAR VENDA

                    </button>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

let cart = [];

/* ================= SOM ================= */
function playBeep() {
    const audio = new Audio('/sounds/beep.mp3');
    audio.play();
}

/* ================= ADD ================= */
function add(id, name, price, stock) {

    playBeep();

    let item = cart.find(p => p.id === id);

    if (item) {
        if (item.qty < stock) item.qty++;
    } else {
        cart.push({ id, name, price, qty: 1, stock });
    }

    render();
}

/* ================= RENDER ================= */
function render() {

    let div = document.getElementById('cart');
    div.innerHTML = '';

    let total = 0;

    cart.forEach((item, index) => {

        total += item.price * item.qty;

        div.innerHTML += `
            <div class="bg-slate-50 p-3 rounded-xl">

                <div class="flex justify-between">

                    <div>
                        <div class="font-bold">${item.name}</div>
                        <div class="text-sm text-gray-500">
                            ${item.price} x ${item.qty}
                        </div>
                    </div>

                    <button onclick="removeItem(${index})"
                            class="text-red-500 font-bold">✕</button>

                </div>

                <div class="flex gap-2 mt-2">

                    <button onclick="dec(${index})"
                            class="bg-gray-200 px-3 rounded">-</button>

                    <button onclick="inc(${index})"
                            class="bg-gray-200 px-3 rounded">+</button>

                </div>

            </div>
        `;
    });

    document.getElementById('total').innerText = total + " MZN";
    calcChange();
}

/* ================= CONTROLOS ================= */
function inc(i) {
    if (cart[i].qty < cart[i].stock) cart[i].qty++;
    render();
}

function dec(i) {
    if (cart[i].qty > 1) cart[i].qty--;
    render();
}

function removeItem(i) {
    cart.splice(i, 1);
    render();
}

/* ================= TROCO ================= */
function calcChange() {

    let total = cart.reduce((s,i)=> s + i.price*i.qty,0);

    let cash = parseFloat(document.getElementById('cash').value || 0);

    let change = cash - total;

    document.getElementById('change').innerText =
        (change >= 0 ? change : 0) + " MZN";
}

/* ================= CHECKOUT (CORRIGIDO) ================= */
function checkout() {

    if (cart.length === 0) {
        alert("Carrinho vazio!");
        return;
    }

    let btn = document.querySelector('button[onclick="checkout()"]');
    btn.disabled = true;
    btn.innerText = "A processar...";

    let cash = parseFloat(document.getElementById('cash').value || 0);
    let total = cart.reduce((s,i)=> s + i.price*i.qty,0);
    let change = cash - total;

    fetch("{{ route('pos.checkout') }}", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            cart: cart,
            total: total,
            cash: cash
        })
    })
    .then(res => res.json())
    .then(data => {

        /* 🔴 BLOQUEIO DE ERRO DO BACKEND */
        if (data.error) {
            alert(data.error);
            btn.disabled = false;
            btn.innerText = "💳 FINALIZAR VENDA";
            return;
        }

        openReceipt(cash, total, change);

        alert(data.message);

        cart = [];
        document.getElementById('cash').value = '';
        render();

        btn.disabled = false;
        btn.innerText = "💳 FINALIZAR VENDA";

        location.reload();
    })
    .catch(() => {
        alert("Erro ao processar venda");
        btn.disabled = false;
        btn.innerText = "💳 FINALIZAR VENDA";
    });
}

/* ================= RECIBO ================= */
function openReceipt(cash, total, change) {

    let win = window.open('', '_blank', 'width=420,height=650');

    let rows = '';

    cart.forEach(item => {
        rows += `
            <tr>
                <td>${item.name}</td>
                <td style="text-align:center">${item.qty}</td>
                <td style="text-align:right">${item.price * item.qty} MZN</td>
            </tr>
        `;
    });

    win.document.write(`
        <html>
        <head>
            <title>Recibo</title>
            <style>
                body { font-family: Arial; padding: 15px; }
                h2 { text-align:center; }
                table { width:100%; border-collapse: collapse; }
                th, td { border-bottom:1px dashed #ccc; padding:5px; font-size:13px; }
                .total { font-weight:bold; margin-top:10px; }
                button { width:100%; padding:10px; margin-top:15px; background:green; color:#fff; border:none; }
            </style>
        </head>
        <body>

            <h2>🛒 MINHA LOJA</h2>

            <table>
                <tr>
                    <th>Produto</th>
                    <th>Qtd</th>
                    <th>Total</th>
                </tr>
                ${rows}
            </table>

            <div class="total">TOTAL: ${total} MZN</div>
            <div class="total">RECEBIDO: ${cash} MZN</div>
            <div class="total">TROCO: ${change >= 0 ? change : 0} MZN</div>

            <button onclick="window.print()">🖨 Imprimir</button>

        </body>
        </html>
    `);

    win.document.close();
}

/* ================= PESQUISA ================= */
function filterProducts() {

    let value = document.getElementById('search').value.toLowerCase();

    document.querySelectorAll('.product').forEach(btn => {
        let name = btn.getAttribute('data-name');
        btn.style.display = name.includes(value) ? 'block' : 'none';
    });
}

/* ================= ENTER ================= */
document.addEventListener('keydown', function(e) {
    if (e.key === 'Enter' && e.target.tagName !== 'INPUT') {
        checkout();
    }
});

</script>

</x-app-layout>