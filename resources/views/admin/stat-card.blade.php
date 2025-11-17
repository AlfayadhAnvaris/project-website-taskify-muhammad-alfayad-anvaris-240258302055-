@props(['icon', 'label', 'value', 'color' => 'gray'])

<div class="bg-gray-800/50 border border-gray-700 rounded-xl p-4 flex items-center gap-3">
    <i class="fas fa-{{ $icon }} text-{{ $color }}-400 text-xl"></i>
    <div>
        <p class="text-gray-400 text-sm">{{ $label }}</p>
        <p class="text-white text-2xl font-bold">{{ $value }}</p>
    </div>
</div>
