<header class="md:hidden flex items-center justify-between bg-[#2D1E2F] text-white px-4 py-3">
    <h1 class="text-base font-semibold"></h1>
    <button onclick="toggleSidebar()" class="text-2xl focus:outline-none bg-black">
        ☰
    </button>
</header>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('open');
    }
</script>
