const { root_url } = window.formbizz;

const Markup = ({ attributes }) => {

	const url = root_url + 'wp-json/formbizz/v1/form/data';
	console.log('url', url);

	return (
		<div className="form-bizz-wrapper">
			<form id="contact-form" action={root_url + 'wp-json/formbizz/v1/form/data'} method="POST">
				<div className="form-group">
					<label htmlFor="name">Name:</label>
					<input type="text" id="name" name="name" required />
				</div>
				<div className="form-group">
					<label htmlFor="email">Email:</label>
					<input type="email" id="email" name="email" required />
				</div>
				<div className="form-group">
					<label htmlFor="message">Message:</label>
					<textarea id="message" name="message" rows="4" required></textarea>
				</div>
				<button type="submit">Send Message</button>
			</form>
		</div>
	);
};

export default Markup;