<footer class="site-foot"><div class="wrap">
  <span class="brand" style="font-size:18px"><span class="mini-stamp">№ 0001</span><span>Morph<b>Print</b></span></span>
  <span>תוכנה להדפסת מספור רץ ומידע משתנה · Windows ו-Mac · © <?php echo esc_html( date_i18n( 'Y' ) ); ?></span>
</div></footer>
<script>
(function(){
  var el=document.getElementById('cnt'),n=1001;
  if(window.matchMedia&&matchMedia('(prefers-reduced-motion: reduce)').matches)return;
  setInterval(function(){n=n>=1999?1001:n+1;el.textContent=n;el.classList.remove('tick');void el.offsetWidth;el.classList.add('tick')},1100);
})();
</script>

<?php wp_footer(); ?>
</body>
</html>
