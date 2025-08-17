window.onload = function() {
            // Animación de partículas de fondo (heroCanvas)
            const heroCanvas = document.getElementById('heroCanvas');
            const heroScene = new THREE.Scene();
            const heroCamera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
            const heroRenderer = new THREE.WebGLRenderer({ canvas: heroCanvas, alpha: true });
            heroRenderer.setSize(window.innerWidth, window.innerHeight);

            heroCamera.position.z = 5;

            const particleGeometry = new THREE.BufferGeometry();
            const particleCount = 2000;
            const posArray = new Float32Array(particleCount * 3);

            for (let i = 0; i < particleCount * 3; i++) {
                posArray[i] = (Math.random() - 0.5) * 10;
            }

            particleGeometry.setAttribute('position', new THREE.BufferAttribute(posArray, 3));

            const particleMaterial = new THREE.PointsMaterial({
                size: 0.005,
                color: 0x6366f1, // Color índigo
                transparent: true,
                opacity: 0.5
            });

            const particles = new THREE.Points(particleGeometry, particleMaterial);
            heroScene.add(particles);

            function animateHero() {
                requestAnimationFrame(animateHero);
                particles.rotation.x += 0.0005;
                particles.rotation.y += 0.001;
                heroRenderer.render(heroScene, heroCamera);
            }
            animateHero();

            window.addEventListener('resize', () => {
                heroCamera.aspect = window.innerWidth / window.innerHeight;
                heroCamera.updateProjectionMatrix();
                heroRenderer.setSize(window.innerWidth, window.innerHeight);
            });

            // Animación interactiva en el recuadro (interactiveCanvas)
            const interactiveCanvas = document.getElementById('interactiveCanvas');
            const interactiveScene = new THREE.Scene();
            const interactiveCamera = new THREE.PerspectiveCamera(75, interactiveCanvas.clientWidth / interactiveCanvas.clientHeight, 0.1, 1000);
            const interactiveRenderer = new THREE.WebGLRenderer({ canvas: interactiveCanvas, alpha: true });
            interactiveRenderer.setSize(interactiveCanvas.clientWidth, interactiveCanvas.clientHeight);

            interactiveCamera.position.z = 1.5;

            const geometry = new THREE.TorusGeometry(0.5, 0.2, 16, 100);
            const material = new THREE.MeshBasicMaterial({ color: 0x4f46e5 });
            const torus = new THREE.Mesh(geometry, material);
            interactiveScene.add(torus);

            const mouse = new THREE.Vector2();
            let isDragging = false;
            let previousMousePosition = {
                x: 0,
                y: 0
            };

            interactiveCanvas.addEventListener('mousedown', (e) => {
                isDragging = true;
                previousMousePosition = {
                    x: e.clientX,
                    y: e.clientY
                };
            });

            interactiveCanvas.addEventListener('mouseup', () => {
                isDragging = false;
            });

            interactiveCanvas.addEventListener('mousemove', (e) => {
                if (!isDragging) return;
                const deltaMove = {
                    x: e.clientX - previousMousePosition.x,
                    y: e.clientY - previousMousePosition.y
                };
                
                torus.rotation.y += deltaMove.x * 0.005;
                torus.rotation.x += deltaMove.y * 0.005;
                
                previousMousePosition = {
                    x: e.clientX,
                    y: e.clientY
                };
            });

            function animateInteractive() {
                requestAnimationFrame(animateInteractive);
                torus.rotation.x += 0.005;
                torus.rotation.y += 0.005;
                interactiveRenderer.render(interactiveScene, interactiveCamera);
            }
            animateInteractive();

            window.addEventListener('resize', () => {
                const newWidth = interactiveCanvas.clientWidth;
                const newHeight = interactiveCanvas.clientHeight;
                interactiveCamera.aspect = newWidth / newHeight;
                interactiveCamera.updateProjectionMatrix();
                interactiveRenderer.setSize(newWidth, newHeight);
            });
        };