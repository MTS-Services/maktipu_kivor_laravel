 @props(['icon', 'color' => 'primary', 'variant' => 'outline', 'href' => 'javascript:void(0)', 'type' => 'button'])

 @if ($href != 'javascript:void(0)')
     <a href="{{ $href }}" wire:navigate {!! $attributes->merge([
         'class' =>
             'inline-flex items-center justify-center rounded-full bg-bg-secondary p-5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent cursor-pointer transition-all duration-150 ease-linear group',
     ]) !!}>
         <flux:icon :name="$icon" :color="$color" :variant="$variant"
             :class="$attributes->get('iconClass')" />
     </a>
 @else
     <button type="{{ $type }}" {!! $attributes->merge([
         'class' =>
             'inline-flex items-center justify-center rounded-full bg-bg-secondary p-5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent cursor-pointer transition-all duration-150 ease-linear group',
     ]) !!}>
         <flux:icon :name="$icon" :color="$color" :variant="$variant"
             :class="$attributes->get('iconClass')" />
     </button>
 @endif
