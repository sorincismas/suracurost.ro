<?php
namespace GroceryCrud\Core\State;

use GroceryCrud\Core\GroceryCrud;
use GroceryCrud\Core\Render\RenderAbstract;

class InitialState extends StateAbstract implements StateInterface
{
    public function render()
    {
        $this->setInitialData();

        $output = $this->showInitData();

        $render = new RenderAbstract();

        $render->output = json_encode($output);
        $render->outputAsObject = $output;
        $render->isJSONResponse = true;

        return $render;
    }

    public function showInitData()
    {
        $data = (object)[];
        $config = $this->gCrud->getConfig();

        $data->i18n = $this->getI18n();
        $data->subject = (object) [
            'subject_single' => $this->gCrud->getSubject() !== null ? $this->gCrud->getSubject() : '',
            'subject_plural' => $this->gCrud->getSubjectPlural() !== null ? $this->gCrud->getSubjectPlural() : ''
        ];

        $actionButtons = $this->gCrud->getActionButtons();
        $actionButtonsMultiple = $this->gCrud->getActionButtonsMultiple();
        $datagridButtons = $this->gCrud->getDatagridButtons();

        $operations = (object) array(
            'actionButtons' => !empty($actionButtons),
            'actionButtonsMultiple' => !empty($actionButtonsMultiple),
            'datagridButtons' => !empty($datagridButtons),
            'add' => $this->gCrud->getLoadAdd(),
            'clone' => $this->gCrud->getLoadClone(),
            'columns' => $this->gCrud->getLoadColumnsButton(),
            'deleteMultiple' => $this->gCrud->getLoadDeleteMultiple(),
            'deleteSingle' => $this->gCrud->getLoadDelete(),
            'edit' => $this->gCrud->getLoadEdit(),
            'exportData' => $this->gCrud->getLoadExport(),
            'exportExcel' => $this->gCrud->getLoadExportExcel(),
            'exportPdf' => $this->gCrud->getLoadExportPdf(),
            'filters' => $this->gCrud->getLoadFilters(),
            'print' => $this->gCrud->getLoadPrint(),
            'read' => $this->gCrud->getLoadRead(),
            'settings' => $this->gCrud->getLoadSettings(),
            'datagridTitle' => $this->gCrud->getLoadDatagridTitle(),
        );

        $data->language = $this->getLanguage();
        $data->columns = $this->transformFieldsList($this->gCrud->getColumns(), $this->gCrud->getUnsetColumns());
        $data->addFields = $this->getAddFields();
        $data->editFields = $this->getEditFields();
        $data->cloneFields = $this->getCloneFields();
        $data->readFields = $this->transformFieldsList($this->gCrud->getReadFields(), $this->gCrud->getUnsetReadFields());
        $data->readOnlyAddFields = $this->gCrud->getReadOnlyAddFields();
        $data->readOnlyEditFields = $this->gCrud->getReadOnlyEditFields();
        $data->readOnlyCloneFields = $this->gCrud->getReadOnlyCloneFields();

        $data->paging = (object)[
            'defaultPerPage' => $config['default_per_page'],
            'pagingOptions'  => $config['paging_options']
        ];

        $data->primaryKeyField = $this->getPrimaryKeyField();
        $data->fieldTypes = $this->filterTypesPrivateInfo($this->getFieldTypes());
        $data->fieldTypesAddForm = $this->filterTypesPrivateInfo($this->getFieldTypesAddForm());
        $data->fieldTypesEditForm = $this->filterTypesPrivateInfo($this->getFieldTypesEditForm());
        $data->fieldTypesReadForm = $this->filterTypesPrivateInfo($this->getFieldTypesReadForm());
        $data->fieldTypesCloneForm = $this->filterTypesPrivateInfo($this->getFieldTypesCloneForm());
        $data->fieldTypesColumns = $this->filterTypesPrivateInfo($this->getFieldTypeColumns());
        $data->operations = $operations;
        $data->configuration = $this->extraConfigurations();

        $data->actionButtonsMultiple = $actionButtonsMultiple;
        $data->datagridButtons = $datagridButtons;

        $isMasterDetail = $this->gCrud->getIsMasterDetail();
        if ($isMasterDetail) {
            $data->masterDetail = (object)$this->gCrud->getMasterDetailInfo();
        }

        $defaultColumnWidth = $this->gCrud->getDefaultColumnWidth();
        if (!empty($defaultColumnWidth)) {
            $data->columnWidth = $defaultColumnWidth;
        }

        $data = $this->addcsrfToken($data);

        return $data;
    }

    public function extraConfigurations() {
        $data = (object)[];

        $config = $this->gCrud->getConfig();

        if (array_key_exists('url_history', $config)) {
            $data->urlHistory = $config['url_history'];
        }

        if (array_key_exists('action_button_type', $config)) {
            $data->actionButtonType = $config['action_button_type'];
        }

        if (array_key_exists('open_in_modal', $config)) {
            $data->openInModal = $config['open_in_modal'];
        }

        $data->showImagePreview = array_key_exists('show_image_preview', $config)
            ? $config['show_image_preview']
            : false;

        if (array_key_exists('actions_column_side', $config) && in_array($config['actions_column_side'], ['left', 'right'])) {
            $data->leftSideActions = $config['actions_column_side'] === 'left';
            $data->rightSideActions = $config['actions_column_side'] === 'right';
        } else {
            $data->leftSideActions = true;
            $data->rightSideActions = false;
        }

        $data->maxActionButtons = (object)[
            'mobile' =>
                array_key_exists('max_action_buttons', $config) && array_key_exists('mobile', $config['max_action_buttons'])
                    ? $config['max_action_buttons']['mobile']
                    : 1,
            'desktop' =>
                array_key_exists('max_action_buttons', $config) && array_key_exists('desktop', $config['max_action_buttons'])
                    ? $config['max_action_buttons']['desktop']
                    : 2,
        ];

        return $data;
    }

    public function filterTypesPrivateInfo($fieldTypes) {
        foreach ($fieldTypes as &$fieldType) {
            switch ($fieldType->dataType) {
                case GroceryCrud::FIELD_TYPE_BLOB: {
                $fieldType->options = null;
                    break;
                }
                case GroceryCrud::FIELD_TYPE_UPLOAD_MULTIPLE:
                case GroceryCrud::FIELD_TYPE_UPLOAD: {
                    unset($fieldType->options->uploadPath);
                    break;
                }
                default:
                    break;

            }
        }

        return $fieldTypes;
    }

    public function getPrimaryKeyField() {
        return $this->gCrud->getModel()->getPrimaryKeyField();
    }
}