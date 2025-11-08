@props(['file' => null, 'currentPath' => null, 'previewId' => 'image-preview'])

<div class="image-preview mb-3" id="{{ $previewId }}-wrapper">
    @if($file || $currentPath)
        <img src="{{ $file ? $file->temporaryUrl() : asset('storage/' . $currentPath) }}" 
             class="img-fluid rounded" 
             id="{{ $previewId }}" 
             style="max-height: 200px; object-fit: cover;"
             alt="Preview">
    @else
        <div class="border rounded p-3 text-center bg-light">
            <i class="bi bi-image fs-2 text-muted"></i>
            <p class="text-muted mb-0">Belum ada gambar</p>
        </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('livewire:initialized', () => {
    const input = document.querySelector('input[type="file"]');
    const previewEl = document.getElementById('{{ $previewId }}');
    const wrapperEl = document.getElementById('{{ $previewId }}-wrapper');
    
    if (input && wrapperEl) {
        input.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (!file) {
                wrapperEl.innerHTML = `
                    <div class="border rounded p-3 text-center bg-light">
                        <i class="bi bi-image fs-2 text-muted"></i>
                        <p class="text-muted mb-0">Belum ada gambar</p>
                    </div>
                `;
                return;
            }

            if (!file.type.match('image.*')) {
                alert('File harus berupa gambar');
                e.target.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = (e) => {
                wrapperEl.innerHTML = `
                    <img src="${e.target.result}" 
                         class="img-fluid rounded" 
                         id="{{ $previewId }}" 
                         style="max-height: 200px; object-fit: cover;"
                         alt="Preview">
                `;
            };
            reader.readAsDataURL(file);
        });
    }
});
</script>
@endpush