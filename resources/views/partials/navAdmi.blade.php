<!-- resources/views/partials/navbar.blade.php -->
<aside class="w-64 bg-[#1f1b2e] text-white shadow-lg flex flex-col min-h-screen">
    <div class="h-16 flex items-center justify-center bg-[#127475]">
        <span class="text-xl font-bold tracking-wide">Admin Panel</span>
    </div>

    <nav class="flex-grow p-6 space-y-6">
        <h2 class="text-sm text-gray-300 uppercase mb-4">Navegación</h2>

        <a href="{{ url('/administrador/areas') }}" 
   class="flex items-center space-x-3 p-3 rounded-lg hover:bg-[#2a2740] transition 
          {{ Request::is('administrador/areas') ? 'bg-[#3b3a6d]' : '' }}">
    <i class="fas fa-building text-lg"></i>
    <span>Gestionar Áreas</span>
</a>


        <a href="{{ url('/administrador/cursos') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-[#2a2740] transition {{ Request::is('admin/cursos') ? 'bg-[#e07a5f]' : '' }}">
            <i class="fas fa-book-open text-lg"></i>
            <span>Gestionar Cursos</span>
        </a>

        <a href="{{ url('/admin/docentes') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-[#2a2740] transition {{ Request::is('admin/docentes') ? 'bg-[#127475]' : '' }}">
            <i class="fas fa-chalkboard-teacher text-lg"></i>
            <span>Gestionar Docentes</span>
        </a>

        <a href="{{ url('/admin/estudiantes') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-[#2a2740] transition {{ Request::is('admin/estudiantes') ? 'bg-[#805d93]' : '' }}">
            <i class="fas fa-users text-lg"></i>
            <span>Gestionar Estudiantes</span>
        </a>

        <a href="{{ url('/admin/reportes') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-[#2a2740] transition {{ Request::is('admin/reportes') ? 'bg-[#1a1a1a]' : '' }}">
            <i class="fas fa-chart-line text-lg"></i>
            <span>Reportes</span>
        </a>

        <a href="{{ url('/admin/estadisticas') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-[#2a2740] transition {{ Request::is('admin/estadisticas') ? 'bg-[#2e1a47]' : '' }}">
            <i class="fas fa-tachometer-alt text-lg"></i>
            <span>Estadísticas</span>
        </a>
    </nav>
</aside>


