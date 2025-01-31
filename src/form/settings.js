import { __ } from '@wordpress/i18n';
import { memo } from '@wordpress/element';
import { InspectorControls } from '@wordpress/block-editor';
import {
	__experimentalToggleGroupControl as ToggleGroupControl,
	__experimentalToggleGroupControlOption as ToggleGroupControlOption,
	PanelBody, ToggleControl, TextControl, TextareaControl, FontSizePicker, ColorPicker, RangeControl
} from '@wordpress/components';

const Settings = ({ attributes, setAttributes }) => { 

	const { hideName, hideEmail, hideMessage  } = attributes;

	return (
		<>	
			<InspectorControls>
				<PanelBody title={ __( 'Content', 'smart-heading' ) } >
					<ToggleControl
						__nextHasNoMarginBottom
						label="Hide Name"
						checked={hideName}
						onChange={(value) => setAttributes({ hideName: value })}
					/>

					<ToggleControl
						__nextHasNoMarginBottom
						label="Hide Email"
						checked={hideEmail}
						onChange={(value) => setAttributes({ hideEmail: value })}
					/>

					<ToggleControl
						__nextHasNoMarginBottom
						label="Hide Message"
						checked={hideMessage}
						onChange={(value) => setAttributes({ hideMessage: value })}
					/>
				</PanelBody>
			</InspectorControls>
		</>
	)
}

export default memo(Settings);