@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-teal-500 focus:ring-4 focus:ring-teal-100 bg-gray-50 hover:bg-white transition-all duration-200 text-gray-900 placeholder:text-gray-400 disabled:opacity-60 disabled:cursor-not-allowed']) }}>
