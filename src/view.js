
(function () {
	const blocks = document.querySelectorAll('.wp-block-stealth-ratings-block-stealth-ratings-block');
	blocks.forEach((block, blockIndex) => {
		const stars = block.querySelectorAll('.star');
		const feedbackForm = block.querySelector('.stealth-ratings-form');
		const feedbackSuccess = block.querySelector('.stealth-ratings-success');
		const feedbackRedirect = block.querySelector('.stealth-ratings-redirect');
		const starsCaption = block.querySelector('.stealth-ratings-caption');
		const businessName = block.dataset.businessName || '';
		const externalUrl = block.dataset.externalUrl || '';
		const threshold = parseInt(block.dataset.threshold, 10) || 4;
		let rating = 0;
		let submitted = false;

		// Helper to update star visuals
		function updateStars(hovered = 0) {
			stars.forEach((star, idx) => {
				if (hovered) {
					star.classList.toggle('filled', idx < hovered);
				} else {
					star.classList.toggle('filled', idx < rating);
				}
			});
		}
		
		// Star hover/focus
		stars.forEach((star, idx) => {
			star.addEventListener('mouseenter', () => updateStars(idx + 1));
			star.addEventListener('mouseleave', () => updateStars());
			star.addEventListener('focus', () => updateStars(idx + 1));
			star.addEventListener('blur', () => updateStars());
			star.addEventListener('click', () => {
				if(submitted){
					return;
				}
				rating = idx + 1;
				updateStars();
				starsCaption.style.display = 'none';
				if (rating < threshold) {
					feedbackForm.style.display = '';
					feedbackSuccess.style.display = 'none';
					feedbackRedirect.style.display = 'none';
				} else {
					if (externalUrl) {
						setTimeout(() => {
							window.location.href = externalUrl;
						}, 1500);
					}
				}
			});
			// Keyboard accessibility
			star.addEventListener('keydown', (e) => {
				if (e.key === 'Enter' || e.key === ' ') {
					e.preventDefault();
					star.click();
				}
			});
			star.setAttribute('tabindex', '0');
		});

		// Feedback form submit
		if (feedbackForm) {
			feedbackForm.addEventListener('submit', function(e) {
				e.preventDefault();
				const name = feedbackForm.querySelector('input[name="name"]').value;
				const message = feedbackForm.querySelector('textarea[name="feedback"]').value;
				feedbackForm.querySelector('button[type="submit"]').disabled = true;
				fetch('/wp-json/stealth-ratings/v1/send-feedback', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json',
						'X-WP-Nonce': (window.StealthRatingsBlock && window.StealthRatingsBlock.nonce) ? window.StealthRatingsBlock.nonce : ''
					},
					body: JSON.stringify({
						name,
						message,
						rating
					})
				})
				.then(res => res.json())
				.then(data => {
					if (data && data.success) {
						feedbackForm.style.display = 'none';
						feedbackSuccess.style.display = '';
						feedbackRedirect.style.display = 'none';
						feedbackSuccess.innerHTML = `
							<div class="components-notice is-success stealth-ratings-success-message" style="margin-top:2rem;text-align:center;">
								<div style="font-size:1.6rem;line-height:1;margin-bottom:0.5rem;">✅</div>
								<div style="font-size:1.15rem;font-weight:600;">Feedback Received</div>
								<div style="margin:1rem 0 0.5rem 0;">Thank you${name ? ', ' + name : ''}!</div>
								<div style="font-size:1rem;line-height:1.4;">Your feedback has been received and will help <b>${businessName}</b> improve.<br>We appreciate you taking the time to share your thoughts with us.</div>
							</div>
							`;
						} else {
							throw new Error('Submission failed');
						}
					})
				.catch(() => {
					feedbackSuccess.style.display = '';
					feedbackSuccess.innerHTML = `<div class="components-notice is-error" style="margin-top:2rem;text-align:center;">
						<div style="font-size:1.2rem;font-weight:600;">Submission failed</div>
						<div style="margin:1rem 0 0.5rem 0;">Sorry, there was a problem sending your feedback. Please try again later.</div>
					</div>`;
				})
				.finally(() => {
					feedbackForm.querySelector('button[type="submit"]').disabled = false;
					submitted = true;
				});
			});
		}
	});
})();
