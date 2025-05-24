
import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { useState } from '@wordpress/element';
import { PanelBody, TextControl, Button, Notice } from '@wordpress/components';

function Edit(props) {
	const { attributes, setAttributes, isSelected } = props;
	const { businessName, externalUrl, threshold } = attributes;
	const [rating, setRating] = useState(false);
	const [showForm, setShowForm] = useState(false);
	const [submitted, setSubmitted] = useState(false);
	const [feedback, setFeedback] = useState('');
	const [name, setName] = useState('');
	const handleStarClick = (star) => {
		setRating(star);
		setShowForm(star <= threshold);
	};
	const handleSubmit = (e) => {
		e.preventDefault();
		setSubmitted(true);
	};
	return [
		isSelected && (
			<InspectorControls>
				<PanelBody title={__('Block Settings', 'stealth-ratings-block')} initialOpen={true}>
					<TextControl
						label={__('Business Name', 'stealth-ratings-block')}
						value={businessName}
						onChange={(value) => setAttributes({ businessName: value })}
					/>
					<TextControl
						label={__('External URL', 'stealth-ratings-block')}
						value={externalUrl}
						onChange={(value) => setAttributes({ externalUrl: value })}
					/>
					<TextControl
						type="number"
						label={__('Threshold', 'stealth-ratings-block')}
						value={threshold}
						onChange={(value) => setAttributes({ threshold: Number(value) })}
					/>
				</PanelBody>
			</InspectorControls>
		),
		<div { ...useBlockProps() }>
			<h3>{__('Rate Your Experience', 'stealth-ratings-block')}</h3>
			<p>{__('How would you rate your experience with', 'stealth-ratings-block')} {businessName}?</p>
			<div className="stealth-ratings-stars">
				{[1,2,3,4,5].map((star) => (
					<span
						key={star}
						className={star <= rating ? 'star filled' : 'star'}
						onClick={() => handleStarClick(star)}
						style={{ cursor: 'pointer', fontSize: '2rem', color: star <= rating ? '#FFA800' : '#DDD' }}
						aria-label={`${star} star${star > 1 ? 's' : ''}`}
					>
					★
					</span>
				))}
			</div>
			<div style={{ marginTop: '0.5rem', color: '#888', fontSize: '0.9rem' }}>
				{__('Tap a star to rate', 'stealth-ratings-block')}
			</div>

			{showForm && rating && rating <= threshold && !submitted && (
				<form className="stealth-ratings-form" onSubmit={handleSubmit} style={{ marginTop: '1.5rem' }}>
					<p>{__('Thank you for your rating. We\'d love to hear how we can improve.', 'stealth-ratings-block')}</p>
					<TextControl
						label={__('How could', 'stealth-ratings-block') + ` ${businessName} ` + __('have done better?', 'stealth-ratings-block')}
						value={feedback}
						onChange={setFeedback}
						placeholder={__('Please share your thoughts...', 'stealth-ratings-block')}
						required
					/>
					<TextControl
						label={__('Your name (optional)', 'stealth-ratings-block')}
						value={name}
						onChange={setName}
						placeholder={__('John Doe', 'stealth-ratings-block')}
					/>
					<Button
						variant="primary"
						type="submit"
						style={{ marginTop: '1rem', width: '100%' }}
					>
						{__('Submit Feedback', 'stealth-ratings-block')}
					</Button>
				</form>
			)}

			{submitted && (
				<Notice status="success" isDismissible={false} style={{ marginTop: '2rem', textAlign: 'center', maxWidth: '480px', margin: '2rem auto' }}>
					<div style={{ fontSize: '1.1rem', fontWeight: 'bold' }}>{__('Feedback Received', 'stealth-ratings-block')}</div>
					<div style={{ fontSize: '1.3rem', margin: '1rem 0' }}>✓</div>
					<div>{__('Thank you', 'stealth-ratings-block')}{name ? `, ${name}` : ''}!<br/>{__('Your feedback has been received and will help', 'stealth-ratings-block')} {businessName} {__('improve. We appreciate you taking the time to share your thoughts with us.', 'stealth-ratings-block')}</div>
				</Notice>
			)}

			{rating && rating > threshold && !showForm && (
				<Notice status="info" isDismissible={false} style={{ marginTop: '2rem', textAlign: 'center', maxWidth: '480px', margin: '2rem auto' }}>
					<div style={{ marginTop: '1rem' }}>{__('In the published site, you\'ll be taken to:', 'stealth-ratings-block')}</div>
					<div style={{ color: '#2563eb', marginTop: '0.5rem', wordBreak: 'break-all' }}>{externalUrl}</div>
				</Notice>
			)}
		</div>
	];
}

export default Edit;
