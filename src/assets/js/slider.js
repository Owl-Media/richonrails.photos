(function(){
	function Slider(root){
		this.root  = root;
		this.list  = root.querySelector('[data-slider-list]');
		this.slides = Array.from(root.querySelectorAll('[data-slide]'));
		this.prev  = root.querySelector('[data-prev]');
		this.next  = root.querySelector('[data-next]');
		this.dotsWrap = root.querySelector('[data-dots]');
		this.dots  = this.dotsWrap ? Array.from(this.dotsWrap.querySelectorAll('[data-dot]')) : [];
		this.index = 0;

		this.update = () => {
			const x = -this.index * 100;
			this.list.style.transform = 'translateX(' + x + '%)';
			this.slides.forEach((el,i)=>el.setAttribute('aria-hidden', i !== this.index));
			if (this.dots.length){
				this.dots.forEach(d=>d.classList.remove('is-active'));
				this.dots[this.index].classList.add('is-active');
			}
		};

		this.go = (i) => {
			const max = this.slides.length - 1;
			this.index = Math.max(0, Math.min(max, i));
			this.update();
		};

		this.next && this.next.addEventListener('click', ()=> this.go(this.index + 1));
		this.prev && this.prev.addEventListener('click', ()=> this.go(this.index - 1));

		if (this.dots.length){
			this.dots.forEach((btn, i)=>{
				btn.addEventListener('click', ()=> this.go(i));
			});
		}

		// Keyboard support
		this.root.addEventListener('keydown', (e)=>{
			if (e.key === 'ArrowRight') this.go(this.index + 1);
			if (e.key === 'ArrowLeft')  this.go(this.index - 1);
		});
		this.root.setAttribute('tabindex', '0');

		// Basic swipe support
		let startX = null;
		this.root.addEventListener('pointerdown', e => { startX = e.clientX; });
		this.root.addEventListener('pointerup', e => {
			if (startX === null) return;
			const dx = e.clientX - startX;
			if (Math.abs(dx) > 30){
				if (dx < 0) this.go(this.index + 1);
				else this.go(this.index - 1);
			}
			startX = null;
		});

		this.update();
	}

	document.addEventListener('DOMContentLoaded', function(){
		document.querySelectorAll('[data-slider]').forEach(el => new Slider(el));
	});
})();
