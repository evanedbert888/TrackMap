<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-yellow-300 active:bg-yellow-500 focus:outline-none focus:border-yellow-500 focus:ring ring-yellow-300 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
