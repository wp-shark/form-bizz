const { root_url } = window.formbizz;
const Markup = ({ attributes }) => {

	const { hideName, hideEmail, hideMessage } = attributes;
	const url = root_url + 'wp-json/formbizz/v1/form/data';

	return (
		<div className="form-bizz-wrapper">
			<form className="form-bizz" id="contact-form" action={url} method="POST">
				{!hideName && (
					<div className="form-group">
						<label htmlFor="name">Name:</label>
						<input type="text" id="name" name="name" required />
					</div>
				)}
				{!hideEmail && (
					<div className="form-group">
						<label htmlFor="email">Email:</label>
						<input type="email" id="email" name="email" required />
					</div>
				)}
				{!hideMessage && (
					<div className="form-group">
						<label htmlFor="message">Message:</label>
						<textarea id="message" name="message" rows="4" required></textarea>
					</div>
				)}
				<button type="submit">Send Message</button>
			</form>
			<span className="success-message"></span>
		</div>
	);
};

export default Markup;