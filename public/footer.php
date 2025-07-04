    </div>
    <footer class="bg-gray-800 text-white text-center p-4 mt-auto">
        <p>&copy; <?= date('Y') ?> Academia. Todos los derechos reservados.</p>
    </footer>

    <script>
        // Mobile menu toggle functionality
        const mobileMenuButton = document.querySelector('.mobile-menu-button');
        const mobileMenu = document.querySelector('.mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!mobileMenuButton.contains(e.target) && !mobileMenu.contains(e.target)) {
                mobileMenu.classList.add('hidden');
            }
        });
    </script>
</body>

</html>