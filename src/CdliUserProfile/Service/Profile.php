<?php
namespace CdliUserProfile\Service;

use ZfcBase\EventManager\EventProvider;
use CdliUserProfile\Model\ProfileSectionInterface;
use CdliUserProfile\Options\ModuleOptions;

class Profile extends EventProvider
{
    protected $sections = NULL;
    protected $fieldSettings;

    public function __construct(ModuleOptions $options)
    {
        $this->fieldSettings = $options->getFieldSettings();
    }

    public function addSection($name, ProfileSectionInterface $model)
    {
        $model->setFieldSettings(isset($this->fieldSettings[$name])
            ? $this->fieldSettings[$name] : array()
        );
        $this->sections[$name] = $model;
        return $this;
    }

    public function getSections()
    {
        if ($this->sections === null) {
            $this->sections = array();
            $this->getEventManager()->trigger(__FUNCTION__, $this);
        }
        return $this->sections;
    }

    public function getSection($key)
    {
        return $this->sections[$key];
    }

    public function save($data)
    {
        $this->getEventManager()->trigger(__FUNCTION__, $this, array('data'=>$data));
    }
}
