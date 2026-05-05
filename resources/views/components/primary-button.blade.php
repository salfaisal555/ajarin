<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-teal-500 to-cyan-600 border border-transparent rounded-xl font-bold text-sm text-white hover:from-teal-600 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 active:scale-95 transition-all duration-200 shadow-md hover:shadow-lg']) }}>
    {{ $slot }}
</button>
