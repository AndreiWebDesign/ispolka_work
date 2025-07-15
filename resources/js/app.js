import './bootstrap';
import Alpine from 'alpinejs';
import { NCALayerClient } from 'ncalayer-js-client';

window.Alpine = Alpine;
Alpine.start();

window.signForm = function() {
    return {
        link: null,
        async run() {
            const file = this.$refs.file.files[0];
            if (!file) return alert('Выберите PDF');

            // 1. Загружаем файл на сервер
            let fd = new FormData();
            fd.append('pdf', file);
            const up = await fetch('/sign/upload', {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content},
                body: fd
            }).then(r => r.json());

            // 2. Подписываем через NCALayer
            const arr = new Uint8Array(await file.arrayBuffer());
            const base64 = btoa(String.fromCharCode(...arr));
            const nca = new NCALayerClient({ allowKmdHttpApi: true });
            await nca.connect();
            const cms = await nca.basicsSignCMS(
                NCALayerClient.basicsStorageAll,
                base64,
                NCALayerClient.basicsCMSParamsDetached,
                NCALayerClient.basicsSignerSignAny
            );

            // 3. Завершаем на сервере
            const res = await fetch('/sign/finish', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ id: up.id, cms })
            }).then(r => r.json());

            this.link = res.link;
        }
    }
}
