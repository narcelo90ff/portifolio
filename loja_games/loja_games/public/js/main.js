// GameStore — main.js

// Toggle senha
function toggleSenha(id) {
  const el = document.getElementById(id);
  if (el) el.type = el.type === 'password' ? 'text' : 'password';
}

// Máscara CPF
function maskCpf(v) {
  v = v.replace(/\D/g,'').substring(0,11);
  v = v.replace(/(\d{3})(\d)/,'$1.$2');
  v = v.replace(/(\d{3})\.(\d{3})(\d)/,'$1.$2.$3');
  v = v.replace(/(\d{3})\.(\d{3})\.(\d{3})(\d)/,'$1.$2.$3-$4');
  return v;
}
document.querySelectorAll('#cpf').forEach(el => {
  el.addEventListener('input', function(){ this.value = maskCpf(this.value); });
});

// Auto-fechar flash
document.addEventListener('DOMContentLoaded', () => {
  const f = document.getElementById('flash-msg');
  if (f) setTimeout(() => { f.style.transition='opacity .4s'; f.style.opacity='0'; setTimeout(()=>f.remove(),400); }, 4500);
});

// Mobile nav
function toggleMobileNav() {
  document.getElementById('mobileNav')?.classList.toggle('open');
}

// Efeito RGB no hover dos cards de jogo (cursor glow)
document.addEventListener('mousemove', e => {
  document.querySelectorAll('.game-card').forEach(card => {
    const rect = card.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;
    card.style.setProperty('--mx', x + 'px');
    card.style.setProperty('--my', y + 'px');
  });
});
