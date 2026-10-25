{{-- Usage: @include('layouts.partials.stat-card', ['title'=>'...', 'value'=>'...', 'icon'=>'...', 'color'=>'blue']) --}}
<div class="bg-white rounded-xl shadow-sm p-5 flex items-center gap-4">
    <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0
        {{ $color === 'blue'   ? 'bg-blue-100 text-blue-600'   : '' }}
        {{ $color === 'green'  ? 'bg-green-100 text-green-600' : '' }}
        {{ $color === 'yellow' ? 'bg-yellow-100 text-yellow-600': '' }}
        {{ $color === 'red'    ? 'bg-red-100 text-red-600'     : '' }}
        {{ $color === 'purple' ? 'bg-purple-100 text-purple-600':'' }}">
        {!! $icon !!}
    </div>
    <div>
        <div class="text-2xl font-bold text-gray-800">{{ $value }}</div>
        <div class="text-sm text-gray-500">{{ $title }}</div>
    </div>
</div>