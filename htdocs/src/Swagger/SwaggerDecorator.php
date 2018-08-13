<?php
/**
 * Created by Antoine Buzaud.
 * Date: 08/08/2018
 */

namespace App\Swagger;


use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Class SwaggerDecorator
 * @package App\Swagger
 */
final class SwaggerDecorator implements NormalizerInterface
{
    /**
     * @var NormalizerInterface
     */
    private $decorated;

    /**
     * SwaggerDecorator constructor.
     * @param NormalizerInterface $decorated
     */
    public function __construct(NormalizerInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    /**
     * @param mixed $object
     * @param null $format
     * @param array $context
     * @return array|bool|float|int|string
     */
    public function normalize($object, $format = null, array $context = array())
    {
        $docs = $this->decorated->normalize($object, $format, $context);

        $customDefinition = [
            'name' => 'fields',
            'definition' => 'Fields to remove of the output',
            'default' => 'id',
            'in' => 'query',
        ];

        # Override title
        #$docs['info']['title'] = "Shinigami API";

        return $docs;
    }

    /**
     * @param mixed $data
     * @param null $format
     * @return bool
     */
    public function supportsNormalization($data, $format = null)
    {
        return $this->decorated->supportsNormalization($data, $format);
    }

}