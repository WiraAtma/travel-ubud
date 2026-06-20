@php
    $initials   = collect(explode(' ', trim($comment->user->name)))
                    ->take(2)->map(fn($w) => strtoupper(mb_substr($w,0,1)))->join('');
    $colors     = ['bg-indigo-500','bg-pink-500','bg-emerald-500','bg-amber-500','bg-cyan-500','bg-violet-500','bg-rose-500'];
    $avatarColor = $colors[crc32($comment->user->name) % count($colors)];
    $isOwner    = auth()->check() && auth()->id() === $comment->user_id;
    $isAdmin    = auth()->check() && in_array(auth()->user()->role, ['admin','superadmin']);
@endphp

<div>
  <p>Koding Disini</p>
  {{-- ikuti kode yang ada di detail > destination > _comment-item.blade.php --}}
</div>