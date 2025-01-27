import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';
import './editor.scss';
import Markup from './markup';
import Settings from './settings';

export default function Edit( { attributes, setAttributes  } ) {
	const blockProps = useBlockProps();
	return (
		<>
			<Settings
				attributes={attributes}
				setAttributes={setAttributes}
			/>

			<div {...blockProps}>
				<Markup attributes={attributes} />
			</div>
		</>
	);
}