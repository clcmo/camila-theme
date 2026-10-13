/* Camila L. Oliveira — comportamentos do tema (sem dependências). */
(() => {
  'use strict';

  /* Menu em tela cheia */
  const botao = document.querySelector('.topo__menu');
  const menu = document.getElementById('menu-principal');
  if (botao && menu) {
    const alternar = (abrir) => {
      botao.setAttribute('aria-expanded', String(abrir));
      botao.querySelector('.sr').textContent = abrir ? 'Fechar menu' : 'Abrir menu';
      menu.hidden = !abrir;
      document.body.style.overflow = abrir ? 'hidden' : '';
    };
    botao.addEventListener('click', () => alternar(menu.hidden));
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape' && !menu.hidden) { alternar(false); botao.focus(); } });
  }

  document.querySelectorAll('[data-produto-abas]').forEach((tabSet) => {
    const tabList = tabSet.querySelector('[role="tablist"]');
    const tabButtons = Array.from(tabSet.querySelectorAll('[role="tab"]'));
    if (!tabList || !tabButtons.length) return;

    const activateTab = (selectedTab, moveFocus = false) => {
      tabButtons.forEach((tab) => {
        const selected = tab === selectedTab;
        tab.setAttribute('aria-selected', String(selected));
        tab.tabIndex = selected ? 0 : -1;
        const panel = document.getElementById(tab.getAttribute('aria-controls'));
        if (panel) panel.hidden = !selected;
      });
      if (moveFocus) selectedTab.focus();
    };

    tabList.addEventListener('click', (event) => {
      const clickedTab = event.target.closest('[role="tab"]');
      if (clickedTab && tabButtons.includes(clickedTab)) activateTab(clickedTab);
    });

    tabList.addEventListener('keydown', (event) => {
      const focusedTab = event.target.closest('[role="tab"]');
      const currentIndex = tabButtons.indexOf(focusedTab);
      if (currentIndex < 0) return;

      let nextIndex = currentIndex;
      if (event.key === 'ArrowRight') nextIndex = (currentIndex + 1) % tabButtons.length;
      else if (event.key === 'ArrowLeft') nextIndex = (currentIndex - 1 + tabButtons.length) % tabButtons.length;
      else if (event.key === 'Home') nextIndex = 0;
      else if (event.key === 'End') nextIndex = tabButtons.length - 1;
      else return;

      event.preventDefault();
      activateTab(tabButtons[nextIndex], true);
    });

    activateTab(tabButtons.find((tab) => tab.getAttribute('aria-selected') === 'true') || tabButtons[0]);
    tabSet.classList.add('is-ready');
  });

  /* Vídeos: o player do YouTube só carrega quando a pessoa clica */
  document.addEventListener('click', (e) => {
    const gatilho = e.target.closest('.video__botao');
    if (!gatilho) return;
    const quadro = gatilho.closest('.video__quadro');
    const url = quadro && quadro.dataset.embed;
    if (!url) return;
    const iframe = document.createElement('iframe');
    iframe.src = url;
    iframe.title = gatilho.getAttribute('aria-label') || 'Vídeo';
    iframe.allow = 'accelerometer; autoplay; encrypted-media; picture-in-picture';
    iframe.allowFullscreen = true;
    quadro.replaceChildren(iframe);
  });

  /* Sons: um toca por vez; barra de progresso clicável */
  const itens = document.querySelectorAll('[data-som]');
  const pararOutros = (atual) => itens.forEach((el) => {
    if (el !== atual) { const a = el.querySelector('audio'); if (a && !a.paused) a.pause(); }
  });
  itens.forEach((item) => {
    const audio = item.querySelector('audio');
    const toca = item.querySelector('.som__botao');
    const barra = item.querySelector('.som__barra');
    const preenche = barra && barra.querySelector('i');
    if (!audio || !toca) return;
    if (!audio.getAttribute('src')) { toca.disabled = true; return; }

    toca.addEventListener('click', () => { audio.paused ? (pararOutros(item), audio.play()) : audio.pause(); });
    audio.addEventListener('play', () => { item.classList.add('tocando'); toca.setAttribute('aria-pressed', 'true'); });
    audio.addEventListener('pause', () => { item.classList.remove('tocando'); toca.setAttribute('aria-pressed', 'false'); });
    audio.addEventListener('timeupdate', () => {
      if (!audio.duration || !preenche) return;
      const pct = (audio.currentTime / audio.duration) * 100;
      preenche.style.width = pct + '%';
      barra.setAttribute('aria-valuenow', String(Math.round(pct)));
    });
    barra && barra.addEventListener('click', (e) => {
      if (!audio.duration) return;
      const r = barra.getBoundingClientRect();
      audio.currentTime = ((e.clientX - r.left) / r.width) * audio.duration;
    });
  });
})();
