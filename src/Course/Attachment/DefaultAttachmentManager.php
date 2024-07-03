<?php

declare(strict_types=1);

namespace App\Course\Attachment;

use App\Entity\Course;
use App\Entity\Media;
use App\File\Uploader\FileUploader;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class DefaultAttachmentManager implements AttachmentManagerInterface
{
    public function __construct(private readonly FileUploader $processor)
    {
    }

    public function save(Course $course): Course
    {
        /** @var UploadedFile $mainVideoFile */
        $mainVideoFile = $course->getVideoPath();

        if ($mainVideoFile) {
            $this->handleCourseMainVideo($course, $mainVideoFile);
        }

        $attachments = $course->getMedias();

        if (\count($attachments) > 0) {
            /** @var Media $attachment */
            foreach ($attachments as $attachment) {
                /** @var UploadedFile $file */
                $file = $attachment->getAttachmentFile();

                if (null === $file) {
                    continue;
                }

                $this->addCourseAttachment($attachment, $file);
            }
        }

        return $course;
    }

    private function handleCourseMainVideo(Course $course, UploadedFile $mainVideo): void
    {
        $attachmentUrl = $this->processor->upload($mainVideo);

        $course->setVideoPathName($attachmentUrl);
    }

    private function addCourseAttachment(Media $attachment, UploadedFile $file): void
    {
        $attachmentNewFilename = $this->doPerformUpload($file);

        $attachment->setFileName($attachmentNewFilename);
    }

    private function doPerformUpload(UploadedFile $media): string
    {
        return $this->processor->upload($media);
    }
}
