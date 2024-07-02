<?php



namespace App\Tests\Transformer;

use App\DataFixtures\AppFixtures;
use App\Entity\Course;
use App\Transformer\CourseToDocumentAdapter;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CourseToDocumentAdapterTest extends KernelTestCase
{
    private CourseToDocumentAdapter $adapter;
    private $entityManager;

    protected function setUp(): void
    {
        parent::setUp();

        $kernel = self::bootKernel();

        
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

       
        $fixtures = new AppFixtures();
        $fixtures->load($this->entityManager);

        $this->adapter = new CourseToDocumentAdapter();
    }

    public function testConvertWithCategory(): void
    {
        $course = $this->entityManager->getRepository(Course::class)->findOneBy(['label' => 'Course 1']);

       
        $document = $this->adapter->convert($course);

       
        $this->assertEquals((string) $course->getId(), $document->getId());
        $this->assertEquals($course->getLabel(), $document->get('label'));
        $this->assertEquals($course->getDescription(), $document->get('description'));

      
        $category = $course->getCategory();
        if ($category !== null) {
            $documentCategory = $document->get('category');
            $this->assertEquals($category->getId(), $documentCategory['id']);
            $this->assertEquals($category->getLabel(), $documentCategory['label']);
        } else {
            $this->assertNull($document->get('category'));
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();

      
        if ($this->entityManager !== null) {
            $this->entityManager->close();
            $this->entityManager = null;
        }
    }
}
