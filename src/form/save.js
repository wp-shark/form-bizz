import { useBlockProps } from '@wordpress/block-editor';
import Markup from './markup';
export default function save( { attributes } ) {

	const blockProps = useBlockProps.save();
	const { headingText, descriptionText, headingTitleSize, headingTitleColor, headingTitleMarginBottom } = attributes;
	
	return (
		<div {...blockProps}>
			<Markup attributes={attributes} />
		</div>
	);
}