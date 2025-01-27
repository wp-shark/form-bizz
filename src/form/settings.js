import { __ } from '@wordpress/i18n';
import { memo } from '@wordpress/element';
import { InspectorControls } from '@wordpress/block-editor';
import {
	__experimentalToggleGroupControl as ToggleGroupControl,
	__experimentalToggleGroupControlOption as ToggleGroupControlOption,
	PanelBody, TextControl, TextareaControl, FontSizePicker, ColorPicker, RangeControl
} from '@wordpress/components';

const Settings = ({ attributes, setAttributes }) => { 

	const { } = attributes;

	return (
		<>	
			<InspectorControls>
				<PanelBody title={ __( 'Content', 'smart-heading' ) } >

				</PanelBody>
			</InspectorControls>
		</>
	)
}

export default memo(Settings);