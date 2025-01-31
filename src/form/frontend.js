window.addEventListener('load', () => {
	const form = document.querySelector('.form-bizz');

	if (form) {
		form.addEventListener('submit', async (e) => {
			e.preventDefault();

			const formData = new FormData(form);
			const action = form.getAttribute('action');

			// Convert FormData to JSON
			const jsonObject = {};
			formData.forEach((value, key) => {
				jsonObject[key] = value;
			});

			try {
				const response = await fetch(action, {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json',
					},
					body: JSON.stringify(jsonObject),
				});

				const data = await response.json();

				if (data.success) {
					form.reset();
				} else {
					alert(data.message || 'Form submission failed');
				}
			} catch (error) {
				console.error('Error submitting form:', error);
			}
		});
	}
});
