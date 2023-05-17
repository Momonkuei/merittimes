<link rel="stylesheet" href="js_v4/swiper/css/swiper.min.css">
<link rel="stylesheet" href="js_v4/lightgallery/css/lightgallery.min.css">
<link rel="stylesheet" href="js_v4/slick/slick.css">
<link rel="stylesheet" href="fonts/fontawesome/css/font-awesome.css">
<link rel="stylesheet" href="fonts/icomoon/style.css">
<link rel="stylesheet" href="js_v4/fancybox/jquery.fancybox.min.css">
<link rel="stylesheet" href="js_v4/dataTables/jquery.dataTables.min.css">
<link rel="stylesheet" href="js_v4/scrollanimate/animate.css">

<!-- 2022/10/31 kuei引用套件 aos -->
<!-- <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"> -->

<!-- Select2 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Noto+Sans+TC:wght@300;400;500;700;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="js_v4/aos/css/aos.css">
<!--<link rel="stylesheet" href="css_v4/content.css">--><?php //for 拖拉套版樣式 
														?>
<link rel="stylesheet" href="css_v4/style.css?v=1.15">
<link rel="stylesheet" href="css_v4/template.css">
<link rel="stylesheet" href="js_v4/slicklightbox/slick-lightbox.css">
<link rel="stylesheet" href="js_v4/flipster/jquery.flipster.min.css">
<link rel="stylesheet" href="js_v4/toast/toast.css">
<link rel="stylesheet" href="css_v4/style_cowboy.css?v=1.1">
<link rel="stylesheet" href="css_v4/external.css"><?php //for 設計使用 
													?>
<meta name="viewport" content="width=device-width">

<?php if (0) : ?>
	<!-- bannerStyle08專用 -->
	<script>
		! function(e) {
			"undefined" == typeof module ? this.charming = e : module.exports = e
		}(function(e, n) {
			"use strict";
			n = n || {};
			var t = n.tagName || "span",
				o = null != n.classPrefix ? n.classPrefix : "char",
				r = 1,
				a = function(e) {
					for (var n = e.parentNode, a = e.nodeValue, c = a.length, l = -1; ++l < c;) {
						var d = document.createElement(t);
						o && (d.className = o + r, r++), d.appendChild(document.createTextNode(a[l])), n.insertBefore(d, e)
					}
					n.removeChild(e)
				};
			return function c(e) {
				for (var n = [].slice.call(e.childNodes), t = n.length, o = -1; ++o < t;) c(n[o]);
				e.nodeType === Node.TEXT_NODE && a(e)
			}(e), e
		});
	</script>
<?php endif ?>