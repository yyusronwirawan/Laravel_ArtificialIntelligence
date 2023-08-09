( () => {
	"use strict";

	const siteHeader = document.querySelector( '.site-header' );
	const navbarExpander = document.querySelector( '.navbar-expander' );
	const dropdownMenus = document.querySelectorAll( '.dropdown-menu' );
	const mobileNavTrigger = document.querySelector( '.mobile-nav-trigger' );
	const siteNavContainer = document.querySelector( '.site-nav-container' );
	const templatesShowMore = document.querySelector( '.templates-show-more' );
	const filterTriggers = document.querySelectorAll( 'button[data-target]' );
	const frontendLocalNav = document.querySelector( '#frontend-local-navbar' );
	const verticalNav = document.querySelector( '.navbar-vertical' );
	const textRotators = document.querySelectorAll( '.lqd-text-rotator' );
	let siteHeaderOffsetTop = siteHeader?.offsetTop || 0;
	let lastActiveTrigger = null;
	let lastOpenedAccordion = null;

	function onVerticalNavTransitionend( ev ) {
		if ( ev.target !== verticalNav ) return;
		verticalNav.style.whiteSpace = '';
		verticalNav.classList.remove( 'lqd-is-collapsing' );
	}

	function toggleVerticalNavShrink( enterOrLeave ) {
		const navbarShrinkIsActive = localStorage.getItem( 'lqd-navbar-shrinked' );
		if ( navbarShrinkIsActive == 'false' || window.innerWidth <= 991 ) return;
		document.body.classList.toggle( 'navbar-shrinked', enterOrLeave === 'leave' );
		verticalNav.style.whiteSpace = 'nowrap';
		verticalNav.classList.add( 'lqd-is-collapsing' );
		verticalNav.removeEventListener( 'transitionend', onVerticalNavTransitionend );
		verticalNav.addEventListener( 'transitionend', onVerticalNavTransitionend )
	}

	function handleStickyHeader() {
		if ( !siteHeader ) return;
		if ( window.scrollY >= siteHeaderOffsetTop ) {
			siteHeader.classList.add( 'lqd-is-sticky' );
			siteHeader.style.position = 'fixed';
			siteHeader.style.top = '0';
		} else {
			siteHeader.classList.remove( 'lqd-is-sticky' );
			siteHeader.style.position = '';
			siteHeader.style.top = '';
		}
	}

	function bannerGradient() {

		const COLORS = [
			{ r: 202, g: 113, b: 255 },
			{ r: 52, g: 113, b: 242 },
			{ r: 132, g: 105, b: 204 },
			{ r: 24, g: 63, b: 240 },
		];

		const canvas = document.getElementById( 'banner-bg' );

		class AnimatedGradient {
			constructor() {
				this.canvas = canvas;
				if ( !this.canvas ) return;
				this.ctx = this.canvas.getContext( '2d' );
				this.raf = null;

				this.pixelRatio = ( window.devicePixelRatio > 1 ) ? 2 : 2;
				this.totalParticles = 4;
				this.particles = [];
				this.maxRadius = 900;
				this.minRadius = 400;

				window.addEventListener( 'resize', this.resize.bind( this ), false );
				this.resize();

				const observer = new IntersectionObserver( ( [ entry ] ) => {
					if ( entry.isIntersecting ) {
						this.startAnimate = true;
						this.raf = window.requestAnimationFrame( this.animate.bind( this ) );
						entry.target.classList.remove( 'invisible' );
					} else {
						this.startAnimate = false;
						window.cancelAnimationFrame( this.raf );
						entry.target.classList.add( 'invisible' );
					}
				} );

				observer.observe( canvas );

			}

			resize() {
				this.stageWidth = window.innerWidth;
				this.stageHeight = window.innerHeight;

				this.canvas.width = this.stageWidth * this.pixelRatio;
				this.canvas.height = this.stageHeight * this.pixelRatio;
				this.ctx.scale( this.pixelRatio, this.pixelRatio );

				this.ctx.globalCompositeOperation = 'saturation';

				this.createParticles();

			}

			createParticles() {
				let curColor = 0;
				this.particles = [];

				for ( let i = 0; i < this.totalParticles; i++ ) {
					const item = new GlowParticle(
						Math.random() * this.stageWidth,
						Math.random() * this.stageHeight,
						Math.random() *
						( this.maxRadius - this.minRadius ) + this.minRadius,
						COLORS[ curColor ]
					);

					if ( ++curColor >= COLORS.length ) {
						curColor = 0;
					}


					this.particles[ i ] = item;

				}

			}

			animate() {

				if ( !this.startAnimate ) {
					return window.cancelAnimationFrame( this.raf );
				};

				this.raf = window.requestAnimationFrame( this.animate.bind( this ) );
				this.ctx.clearRect( 0, 0, this.stageWidth, this.stageHeight );

				for ( let i = 0; i < this.totalParticles; i++ ) {
					const item = this.particles[ i ];
					item.animate( this.ctx, this.stageWidth / 1.5, this.stageHeight / 1.5 );
				}
			}

		}

		window.onload = () => {
			new AnimatedGradient();
		}

		const PI2 = Math.PI * 2;
		class GlowParticle {
			constructor( x, y, radius, rgb ) {
				this.x = x;
				this.y = y;
				this.radius = radius;
				this.rgb = rgb;

				this.vx = Math.random() * 4;
				this.vy = Math.random() * 4;

				this.sinValue = Math.random();

			}
			animate( ctx, stageWidth, stageHeight ) {
				this.sinValue += 0.01;

				this.radius += Math.sin( this.sinValue );
				this.x += this.vx;
				this.y += this.vy;

				if ( this.x < 0 ) {
					this.vx *= -1;
					this.x += 10;
				} else if ( this.x > stageWidth ) {
					this.vx *= -1;
					this.x -= 10;
				}

				if ( this.y < 0 ) {
					this.vy *= -1;
					this.y += 10;
				} else if ( this.y > stageHeight ) {
					this.vy *= -1;
					this.y -= 10;
				}

				ctx.beginPath();
				const g = ctx.createRadialGradient(
					this.x,
					this.y,
					this.radius * 0.01,
					this.x,
					this.y,
					this.radius
				);
				g.addColorStop( 0, `rgba(${ this.rgb.r }, ${ this.rgb.g }, ${ this.rgb.b }, 1)` );
				g.addColorStop( 1, `rgba(${ this.rgb.r }, ${ this.rgb.g }, ${ this.rgb.b }, 0)` );
				ctx.fillStyle = g;
				ctx.arc( this.x, this.y, this.radius, 0, PI2, false )
				ctx.fill();

			}
		}

	}

	function onWindowScroll( ev ) {
		handleStickyHeader();
	}

	function onWindowResize() {
		if ( siteHeader ) {
			siteHeader.classList.remove( 'lqd-is-sticky' );
			siteHeader.style.position = '';
			siteHeader.style.top = '';
			siteHeaderOffsetTop = siteHeader?.offsetTop || 0;
		}
		handleStickyHeader();
	}

	textRotators?.forEach( textRotator => {
		const items = textRotator.querySelectorAll( '.lqd-text-rotator-item' );

		if ( !items.length ) return;

		const timeout = 2000;
		let activeIndex = 0;

		textRotator.style.width = `${ items[ activeIndex ].querySelector( 'span' ).clientWidth }px`;

		setInterval( () => {
			// current item
			items[ activeIndex ].classList.remove( 'lqd-is-active' );

			// now next item
			activeIndex = activeIndex === items.length - 1 ? 0 : activeIndex + 1;
			textRotator.style.width = `${ items[ activeIndex ].querySelector( 'span' ).clientWidth }px`;
			items[ activeIndex ].classList.add( 'lqd-is-active' );
		}, timeout );
	} );

	dropdownMenus.forEach( dd => {
		if ( document.body.classList.contains( 'navbar-shrinked' ) ) {
			dd.classList.remove( 'show' );
		}
	} );

	// verticalNav?.addEventListener( 'mouseenter', toggleVerticalNavShrink.bind( verticalNav, 'enter' ) );
	// verticalNav?.addEventListener( 'mouseleave', toggleVerticalNavShrink.bind( verticalNav, 'leave' ) );

	navbarExpander?.addEventListener( 'click', event => {
		event.preventDefault();
		const navbarIsShrinked = document.body.classList.contains( 'navbar-shrinked' );
		document.body.classList.toggle( 'navbar-shrinked' );
		localStorage.setItem( 'lqd-navbar-shrinked', !navbarIsShrinked );
	} );

	document.addEventListener( 'click', ev => {
		const { target } = ev;
		dropdownMenus
			.forEach( dd => {
				if ( !document.body.classList.contains( 'navbar-shrinked' ) && dd.closest( '.primary-nav' ) ) return;
				const clickedOutside = !dd.parentElement.contains( target );
				if ( clickedOutside ) {
					dd.classList.remove( 'show' );
					searchResultsVisible = false;
				};
			} )
	} );

	templatesShowMore?.addEventListener( 'click', ev => {
		ev.preventDefault();
		const list = document.querySelector( '.templates-cards' );
		const overlay = document.querySelector( '.templates-cards-overlay' );
		list.style.overflow = 'visible';
		list.animate(
			[
				// keyframes
				{ maxHeight: '28rem' },
				{ maxHeight: '500rem' },
			],
			{
				// timing options
				duration: 3000,
				easing: 'ease-out',
				fill: 'forwards'
			}
		);
		overlay.animate(
			[
				{ opacity: 0 }
			],
			{
				duration: 650,
				fill: 'forwards',
				easing: 'ease-out'
			}
		);
		const btnAnima = templatesShowMore.animate(
			[
				{ opacity: 0 }
			],
			{
				duration: 650,
				fill: 'forwards',
				easing: 'ease-out'
			}
		);
		btnAnima.onfinish = () => {
			overlay.style.visibility = 'hidden';
			templatesShowMore.style.visibility = 'hidden';
		}
	} );

	filterTriggers?.forEach( trigger => {
		const targetId = trigger.getAttribute( 'data-target' );
		const targets = document.querySelectorAll( targetId );
		const triggerType = trigger.getAttribute( 'data-trigger-type' ) || 'toggle';

		if ( targets.length <= 0 ) {
			return trigger.setAttribute( 'disabled', true );
		};

		trigger.addEventListener( 'click', ev => {
			ev?.preventDefault();

			trigger.classList.add( 'lqd-is-active' );

			if ( triggerType === 'toggle' ) {
				[ ...trigger.parentElement.children ]
					.filter( c => c.getAttribute( 'data-target' ) !== targetId )
					.forEach( c => c.classList.remove( 'lqd-is-active' ) );
			} else if ( triggerType === 'accordion' ) {
				if ( lastActiveTrigger ) {
					lastActiveTrigger.classList.remove( 'lqd-is-active' );
				}
				if ( lastActiveTrigger === trigger ) {
					lastActiveTrigger = null;
				} else {
					lastActiveTrigger = trigger;
				}
			}

			targets?.forEach( t => {
				t.style.display = 'block';
				t.animate(
					[
						{ opacity: 0 },
						{ opacity: 1 },
					],
					{
						duration: 650,
						easing: 'cubic-bezier(.48,.81,.52,.99)'
					}
				);
			} );

			if ( triggerType === 'toggle' ) {
				[ ...targets[ 0 ]?.parentElement?.children ]
					?.filter( c => targetId.startsWith( '.' ) ? !c.classList.contains( targetId.replace( '.', '' ) ) : c.getAttribute( 'id' ) !== targetId.replace( '#', '' ) )
					?.forEach( c => c.style.display = 'none' );
			} else if ( triggerType === 'accordion' ) {
				if ( lastOpenedAccordion ) {
					lastOpenedAccordion.style.display = 'none';
				}
				if ( lastOpenedAccordion === targets[ 0 ] ) {
					lastOpenedAccordion = null;
				} else {
					lastOpenedAccordion = targets[ 0 ];
				}
			}
		} )
	} );

	if ( frontendLocalNav ) {
		const scrollspy = VanillaScrollspy( { menu: frontendLocalNav } )
		scrollspy.init()
	}

	mobileNavTrigger?.addEventListener( 'click', ev => {
		ev.preventDefault();
		mobileNavTrigger.classList.toggle( 'lqd-is-active' );
		siteNavContainer.classList.toggle( 'lqd-is-active' );
	} );

	bannerGradient();

	window.addEventListener( 'scroll', onWindowScroll );

	window.addEventListener( 'resize', onWindowResize );

} )();