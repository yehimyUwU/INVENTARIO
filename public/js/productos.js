document.addEventListener('DOMContentLoaded', function() {
    cargarCategorias();
    cargarProductos();
    cargarUsuarios();
    document.getElementById('verPerfil').addEventListener('click', verPerfil);
    document.getElementById('editarPerfilBtn').addEventListener('click', editarPerfil);
    document.getElementById('listaProductos').addEventListener('click', function(event) {
        if (event.target.classList.contains('btn-primary')) {
            editarProducto(event.target.closest('tr').dataset.id);
        }
    });
});

function cargarCategorias() {
    fetch('../../models/php/cargar_categorias.php') // Ruta corregida
        .then(response => response.json())
        .then(data => {
            const categoriaSelect = document.getElementById('categoriaGeneral');
            const categoriaSelectSub = document.getElementById('categoriaGeneralSub');
            data.forEach(categoria => {
                const option = document.createElement('option');
                option.value = categoria.id_categoria;
                option.textContent = categoria.nombre;
                categoriaSelect.appendChild(option);
                categoriaSelectSub.appendChild(option.cloneNode(true));
            });
        })
        .catch(error => {
            console.error('Error al cargar las categorías:', error);
            alert('Error al cargar las categorías.');
        });
}

function cargarSubcategorias() {
    const categoriaId = document.getElementById('categoriaGeneral').value;
    fetch(`../../models/php/cargar_subcategorias.php?id_categoria=${categoriaId}`) // Ruta corregida
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            const subcategoriaSelect = document.getElementById('subcategoria');
            subcategoriaSelect.innerHTML = '<option value="">Seleccione una subcategoría</option>';
            data.forEach(subcategoria => {
                const option = document.createElement('option');
                option.value = subcategoria.id_subcategoria;
                option.textContent = subcategoria.nombre;
                subcategoriaSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error al cargar las subcategorías:', error);
            alert('Error al cargar las subcategorías.');
        });
}

function cargarProductos() {
    fetch('../../models/php/cargar_productos.php') // Ruta corregida
        .then(response => response.json())
        .then(data => {
            const listaProductos = document.getElementById('listaProductos');
            listaProductos.innerHTML = '';
            data.forEach(producto => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${producto.id_producto}</td>
                    <td>${producto.nombre}</td>
                    <td>${producto.descripcion}</td>
                    <td>€${producto.precio}</td>
                    <td>${producto.stock}</td>
                    <td><button class="btn btn-primary">Editar</button> <button class="btn btn-danger">Eliminar</button></td>
                `;
                listaProductos.appendChild(row);
            });
        })
        .catch(error => {
            console.error('Error al cargar los productos:', error);
            alert('Error al cargar los productos.');
        });
}

function cargarUsuarios() {
    fetch('../../models/php/cargar_usuarios.php') // Ruta corregida
        .then(response => response.json())
        .then(data => {
            const listaUsuarios = document.getElementById('listaUsuarios');
            listaUsuarios.innerHTML = '';
            data.forEach(usuario => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${usuario.id_usuario}</td>
                    <td>${usuario.nombre}</td>
                    <td>${usuario.apellido}</td>
                    <td>${usuario.email}</td>
                    <td><button class="btn btn-primary">Editar</button> <button class="btn btn-danger">Eliminar</button></td>
                `;
                listaUsuarios.appendChild(row);
            });
        })
        .catch(error => {
            console.error('Error al cargar los usuarios:', error);
            alert('Error al cargar los usuarios.');
        });
}

document.getElementById('formularioProducto').addEventListener('submit', function(event) {
    event.preventDefault();
    const formData = new FormData(this);
    fetch('../../models/php/registrar_producto.php', { // Ruta corregida
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Producto registrado con éxito');
            cargarProductos();
            document.getElementById('formularioProducto').reset();
            const modal = bootstrap.Modal.getInstance(document.getElementById('crearProductoModal'));
            modal.hide();
        } else {
            alert(data.message || 'Error al registrar el producto');
        }
    })
    .catch(error => {
        console.error('Error al registrar el producto:', error);
        alert('Error al registrar el producto: ' + error.message);
    });
});

document.getElementById('formularioUsuario').addEventListener('submit', function(event) {
    event.preventDefault();
    const formData = new FormData(this);
    fetch('../../models/php/registrar_usuario.php', { // Ruta corregida
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('Usuario registrado con éxito');
            cargarUsuarios();
            document.getElementById('formularioUsuario').reset();
            const modal = bootstrap.Modal.getInstance(document.getElementById('crearUsuarioModal'));
            modal.hide();
        } else {
            alert(data.message || 'Error al registrar el usuario');
        }
    })
    .catch(error => {
        console.error('Error al registrar el usuario:', error);
        alert('Error al registrar el usuario: ' + error.message);
    });
});

document.getElementById('formularioCategoria').addEventListener('submit', function(event) {
    event.preventDefault();
    const formData = new FormData(this);
    fetch('registrar_categoria.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Categoría registrada con éxito');
            cargarCategorias();
            document.getElementById('formularioCategoria').reset();
            const modal = bootstrap.Modal.getInstance(document.getElementById('crearCategoriaModal'));
            modal.hide();
        } else {
            alert(data.message || 'Error al registrar la categoría');
        }
    })
    .catch(error => {
        console.error('Error al registrar la categoría:', error);
        alert('Error al registrar la categoría: ' + error.message);
    });
});

document.getElementById('formularioSubcategoria').addEventListener('submit', function(event) {
    event.preventDefault();
    const formData = new FormData(this);
    fetch('registrar_subcategoria.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Subcategoría registrada con éxito');
            cargarSubcategorias();
            document.getElementById('formularioSubcategoria').reset();
            const modal = bootstrap.Modal.getInstance(document.getElementById('crearSubcategoriaModal'));
            modal.hide();
        } else {
            alert(data.message || 'Error al registrar la subcategoría');
        }
    })
    .catch(error => {
        console.error('Error al registrar la subcategoría:', error);
        alert('Error al registrar la subcategoría: ' + error.message);
    });
});

function verPerfil() {
    fetch('ver_perfil.php')
        .then(response => response.json())
        .then(data => {
            if (data) {
                document.getElementById('perfilNombre').textContent = data.nombre || '';
                document.getElementById('perfilApellido').textContent = data.apellido || '';
                document.getElementById('perfilEmail').textContent = data.email || '';
                document.getElementById('perfilTipoDocumento').textContent = data.tipo_documento || '';
                document.getElementById('perfilDocumento').textContent = data.documento || '';
                document.getElementById('perfilFechaNacimiento').textContent = data.fecha_nacimiento || '';
                document.getElementById('perfilGenero').textContent = data.genero || '';
                const modal = new bootstrap.Modal(document.getElementById('verPerfilModal'));
                modal.show();
            } else {
                alert('No se encontraron datos de perfil.');
            }
        })
        .catch(error => {
            console.error('Error al cargar el perfil:', error);
            alert('Error al cargar el perfil: ' + error.message);
        });
}

function editarPerfil() {
    const formData = new FormData(document.getElementById('formularioEditarPerfil'));
    fetch('editar_perfil.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Perfil actualizado con éxito');
            const modal = bootstrap.Modal.getInstance(document.getElementById('editarPerfilModal'));
            modal.hide();
        } else {
            alert(data.message || 'Error al actualizar el perfil');
        }
    })
    .catch(error => {
        console.error('Error al actualizar el perfil:', error);
        alert('Error al actualizar el perfil: ' + error.message);
    });
}

function editarProducto(id) {
    fetch(`obtener_producto.php?id_producto=${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('editarProductoId').value = data.id_producto;
            document.getElementById('editarNombreProducto').value = data.nombre;
            document.getElementById('editarDescripcion').value = data.descripcion;
            document.getElementById('editarPrecio').value = data.precio;
            document.getElementById('editarStock').value = data.stock;
            document.getElementById('editarCategoriaGeneral').value = data.categoria_id;
            cargarSubcategoriasEditar(data.subcategoria_id);
            const modal = new bootstrap.Modal(document.getElementById('editarProductoModal'));
            modal.show();
        })
        .catch(error => {
            console.error('Error al obtener el producto:', error);
            alert('Error al obtener el producto: ' + error.message);
        });
}

document.getElementById('formularioEditarProducto').addEventListener('submit', function(event) {
    event.preventDefault();
    const formData = new FormData(this);
    fetch('editar_producto.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Producto actualizado con éxito');
            cargarProductos();
            const modal = bootstrap.Modal.getInstance(document.getElementById('editarProductoModal'));
            modal.hide();
        } else {
            alert(data.message || 'Error al actualizar el producto');
        }
    })
    .catch(error => {
        console.error('Error al actualizar el producto:', error);
        alert('Error al actualizar el producto: ' + error.message);
    });
});

function cargarSubcategoriasEditar(subcategoriaId) {
    const categoriaId = document.getElementById('editarCategoriaGeneral').value;
    fetch(`cargar_subcategorias.php?id_categoria=${categoriaId}`)
        .then(response => response.json())
        .then(data => {
            const subcategoriaSelect = document.getElementById('editarSubcategoria');
            subcategoriaSelect.innerHTML = '<option value="">Seleccione una subcategoría</option>';
            data.forEach(subcategoria => {
                const option = document.createElement('option');
                option.value = subcategoria.id_subcategoria;
                option.textContent = subcategoria.nombre;
                if (subcategoria.id_subcategoria == subcategoriaId) {
                    option.selected = true;
                }
                subcategoriaSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error al cargar las subcategorías:', error);
            alert('Error al cargar las subcategorías.');
        });
}
