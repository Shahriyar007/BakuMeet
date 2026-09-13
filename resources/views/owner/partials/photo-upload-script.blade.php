<script>
(function () {
    const input = document.getElementById('photoInput');
    const grid = document.getElementById('photoGrid');
    const submitBtn = document.getElementById('submitBtn');
    const uploadUrl = @json($uploadUrl);
    const csrfToken = @json(csrf_token());

    let activeUploads = 0;

    function setSubmitEnabled() {
        if (!submitBtn) return;
        submitBtn.disabled = activeUploads > 0;
        submitBtn.style.opacity = activeUploads > 0 ? '0.6' : '1';
        submitBtn.textContent = activeUploads > 0
            ? 'Fotoğraflar yükleniyor (' + activeUploads + ')...'
            : submitBtn.dataset.originalText;
    }

    if (submitBtn) {
        submitBtn.dataset.originalText = submitBtn.textContent;
    }

    function makeDeleteForm(photoId, deleteUrlTemplate) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = deleteUrlTemplate.replace('__ID__', photoId);
        form.style.marginTop = '4px';
        form.onsubmit = function () {
            return confirm('Bu fotoğrafı silmek istediğinize emin misiniz?');
        };
        form.innerHTML = '<input type="hidden" name="_token" value="' + csrfToken + '">' +
            '<input type="hidden" name="_method" value="DELETE">' +
            '<button type="submit" style="width: 100%; font-size: 12px; color: red;">Sil</button>';
        return form;
    }

    function showError(statusBox, message) {
        statusBox.textContent = '';
        statusBox.style.background = '#ffe6e6';
        statusBox.style.flexDirection = 'column';
        statusBox.style.fontSize = '10px';
        statusBox.style.padding = '4px';
        statusBox.style.textAlign = 'center';
        statusBox.style.overflow = 'hidden';

        const icon = document.createElement('div');
        icon.style.fontSize = '20px';
        icon.textContent = '❌';
        statusBox.appendChild(icon);

        const msg = document.createElement('div');
        msg.textContent = message;
        statusBox.appendChild(msg);
    }

    if (!input) return;

    input.addEventListener('change', function (e) {
        const files = Array.from(e.target.files);
        if (files.length === 0) return;

        const existingCount = grid.querySelectorAll('.photo-item').length;
        const noPhotosText = document.getElementById('noPhotosText');

        files.forEach(function (file, i) {
            if (existingCount + i >= 5) {
                return;
            }

            const isImage = file.type.startsWith('image/');
            const tooBig = file.size > 5 * 1024 * 1024;

            const item = document.createElement('div');
            item.className = 'photo-item';
            item.style.cssText = 'position: relative; width: 100px;';

            const statusBox = document.createElement('div');
            statusBox.style.cssText = 'width: 100px; height: 100px; border-radius: 4px; background: #eee; display: flex; align-items: center; justify-content: center; font-size: 28px;';
            statusBox.textContent = '⏳';
            item.appendChild(statusBox);
            grid.appendChild(item);

            if (noPhotosText) noPhotosText.style.display = 'none';

            if (!isImage) {
                showError(statusBox, 'Geçerli bir resim dosyası değil');
                return;
            }
            if (tooBig) {
                showError(statusBox, '5MB sınırını aşıyor');
                return;
            }

            activeUploads++;
            setSubmitEnabled();

            const formData = new FormData();
            formData.append('photo', file);

            fetch(uploadUrl, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                body: formData,
            })
                .then(function (res) {
                    return res.text().then(function (text) {
                        let data;
                        try {
                            data = JSON.parse(text);
                        } catch (e) {
                            data = { success: false, message: 'Sunucu hatası (HTTP ' + res.status + ')' };
                        }
                        return { ok: res.ok, status: res.status, data: data };
                    });
                })
                .then(function (result) {
                    activeUploads--;
                    setSubmitEnabled();

                    if (!result.ok || !result.data.success) {
                        showError(statusBox, (result.data && result.data.message) || ('Hata (HTTP ' + result.status + ')'));
                        return;
                    }

                    item.dataset.photoId = result.data.photo_id;
                    item.innerHTML = '<img src="' + result.data.url + '" style="width: 100px; height: 100px; object-fit: cover; border-radius: 4px;">';
                    item.appendChild(makeDeleteForm(result.data.photo_id, @json(route('owner.establishments.photos.destroy', ':id')).replace(':id', '__ID__')));
                })
                .catch(function (err) {
                    activeUploads--;
                    setSubmitEnabled();
                    showError(statusBox, 'Ağ hatası: ' + err.message);
                });
        });

        input.value = '';
    });
})();
</script>
