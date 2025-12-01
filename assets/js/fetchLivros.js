
fetch("jsons/livros.json")
.then(response => {
    if (!response.ok) throw new Error('Erro ao carregar o JSON');
    return response.json();
})
.then(data => {
    livros = data;
    
    let divLivros = document.querySelector('#livros');

    livros.forEach(item => {
      divLivros.innerHTML += `
          <div class="col-lg-4 templatemo-item-col all ${item.categoria}">
            <div class="meeting-item">
              <div style="background-image: url('assets/images/livros/${item.imagem}')" class="thumb"></div>
              <div class="down-content">
                <h4>${item.titulo}</h4>
                <div class="main-button-red">
                  <a style="color: white;">Ver mais</a>
                </div>
              </div>
            </div>
          </div>
        `
    });

    $(window).scroll(function() {
      var scroll = $(window).scrollTop();
      var box = $('.header-text').height();
      var header = $('header').height();

      if (scroll >= box - header) {
        $("header").addClass("background-header");
      } else {
        $("header").removeClass("background-header");
      }
    });

    $('.filters ul li').click(function(){
      $('.filters ul li').removeClass('active');
      $(this).addClass('active');
        
        var data = $(this).attr('data-filter');
        $grid.isotope({
          filter: data
        })
      });

      var $grid = $(".grid").isotope({
        itemSelector: ".all",
        percentPosition: true,
        masonry: {
          columnWidth: ".all"
        }
      });


    if (document.readyState === "loading") {
        document.addEventListener('DOMContentLoaded', inicializarModal);
    } else {
        inicializarModal();
    }

})
.catch(error => console.error('Erro:', error));


function inicializarModal() {
  document.querySelectorAll('.templatemo-item-col').forEach(el => {
    el.style.cursor = "pointer";
    el.addEventListener('click', function () {
      const titulo = this.closest('.templatemo-item-col').querySelector('h4').innerText.trim();
      const livro = livros.find(f => f.titulo.trim().toLowerCase() === titulo.toLowerCase());

      if (livro) {
        document.getElementById('livroModalLabel').innerText = livro.titulo;
        document.getElementById('livroSinopse').innerText = livro.sinopse;

        const fichaDiv = document.getElementById('livroFicha');
        fichaDiv.innerHTML = '';

        const principais = {
          "Autor": livro.autor,
          "Série": livro.serie,
          "Ano": livro.ano
        };

        for (const [chave, valor] of Object.entries(principais)) {
          const p = document.createElement('p');
          p.innerHTML = `<strong>${chave}:</strong> ${valor}`;
          fichaDiv.appendChild(p);
        }

        /*

        for (let key in filme) {
          if (!['id', 'titulo', 'genero', 'duracao', 'local', 'ano', 'sinopse', 'trailer', 'teaser', 'filmeCompleto', "curiosidade", "tematica", "images"].includes(key)) {
            let valor = Array.isArray(filme[key]) ? filme[key].join(', ') : filme[key];
            const chaveFormatada = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
            const p = document.createElement('p');
            p.innerHTML = `<strong>${chaveFormatada}:</strong> ${valor}`;
            fichaDiv.appendChild(p);
          }
        }

        const tabCuriosidade = document.getElementById("curiosidade-tab"); 
        const contentCuriosidade = document.getElementById('filmCuriosidade'); 
        const tematica = document.getElementById('filmTematica'); 
        
        if (filme.curiosidade) {
          contentCuriosidade.innerText = filme.curiosidade;
          contentCuriosidade.style.display = "block";
          tabCuriosidade.style.display = "block";
        } else {
          contentCuriosidade.style.display = "none";
          tabCuriosidade.style.display = "none";
        }

        tematica.innerText = filme.tematica ? (Array.isArray(filme.tematica) ? filme.tematica.join(', ') : filme.tematica) : "Temática indisponível.";

        const filmFotos = document.getElementById("filmFotos");
        filmFotos.innerHTML = "";

        if (filme.images && filme.images.length > 0) {
          totalFotos = filme.images.length;
          filme.images.forEach(image => {
            const img = document.createElement("img");
            img.src = `images/album-fotos/${filme.id}/${image}`;
            img.className = "mx-auto filmImage";
            img.addEventListener("click", () => openLightbox(filme.id, image));
            filmFotos.appendChild(img);
          });
        } else {
          filmFotos.innerText = "Não há fotos disponíveis!";
        }
          */

      } 
      /* else {
        document.getElementById('filmModalLabel').innerText = titulo;
        document.getElementById('filmSinopse').innerText = 'Sinopse não disponível.';
        document.getElementById('filmFicha').innerText = 'Ficha Técnica não disponível.';
        document.getElementById('filmTematica').innerText = 'Temática não disponível.';
        watchLink.href = '#';
        watchContainer.style.display = 'none';
      }
      document.getElementById('shareInstagram').href = `https://www.instagram.com/`;
      document.getElementById('shareFacebook').href = `https://www.facebook.com/sharer/sharer.php?u=${url}&quote=${text}`;
      document.getElementById('shareWhatsApp').href = `https://wa.me/?text=${text}%20${url}`;
      */
      const myModal = new bootstrap.Modal(document.getElementById('livroModal'));
      myModal.show();
    });
  });
}
